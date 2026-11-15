<?php

namespace App\Controllers;

use App\Models\ForumKomentarModel;
use App\Models\ForumTopicModel;
use CodeIgniter\HTTP\RedirectResponse;

/** Forum diskusi per jadwal: guru membuat topik, guru & siswa berkomentar. */
class Forum extends BaseController
{
    public function index(): string
    {
        return $this->halamanPilihJadwal('Forum Diskusi', site_url('forum'), static fn ($r) =>
            '<a class="btn btn-success btn-xs" href="' . site_url('forum/' . $r['kodejdwl']) . '"><span class="glyphicon glyphicon-th-list"></span> Masuk Forum</a>',
            ['Topik' => $this->hitungPerJadwal('rb_forum_topic')]);
    }

    public function daftar(int $kodejdwl): string
    {
        $jadwal = $this->jadwal($kodejdwl);
        $topik  = model(ForumTopicModel::class)
            ->select('rb_forum_topic.*, (SELECT COUNT(*) FROM rb_forum_komentar k WHERE k.id_forum_topic = rb_forum_topic.id_forum_topic) AS jumlah_balasan', false)
            ->where('kodejdwl', $kodejdwl)->orderBy('id_forum_topic', 'DESC')->findAll();

        return view('forum/daftar', ['judul' => 'Forum Diskusi', 'jadwal' => $jadwal, 'topik' => $topik, 'kelola' => $this->bolehKelola()]);
    }

    public function tambah(int $kodejdwl): string
    {
        $this->wajibBolehUbah();

        return view('components/form_jadwal', [
            'judul'  => 'Buat Topik Baru',
            'jadwal' => $this->jadwal($kodejdwl),
            'row'    => [],
            'baru'   => true,
            'action' => site_url("forum/{$kodejdwl}/tambah"),
            'batal'  => site_url("forum/{$kodejdwl}"),
            'field'  => [
                ['name' => 'judul_topic', 'label' => 'Judul Topik', 'rules' => 'required'],
                ['name' => 'isi_topic', 'label' => 'Isi Topik', 'type' => 'textarea', 'rows' => 8, 'rules' => 'required'],
            ],
        ]);
    }

    public function simpan(int $kodejdwl): RedirectResponse
    {
        $this->wajibBolehUbah();
        $this->jadwal($kodejdwl);
        if (! $this->validate(['judul_topic' => 'required|max_length[255]', 'isi_topic' => 'required'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = model(ForumTopicModel::class)->insert($this->inputPost(['judul_topic', 'isi_topic']) + ['kodejdwl' => $kodejdwl, 'waktu' => date('Y-m-d H:i:s')]);

        return $this->kembali(site_url("forum/topik/{$id}"), 'Topik berhasil dibuat.');
    }

    public function topik(int $id): string
    {
        [$topik, $jadwal] = $this->ambilTopik($id);

        // nisn_nip bisa NISN siswa atau NIP guru; ambil nama & foto dari keduanya.
        $komentar = model(ForumKomentarModel::class)
            ->select('rb_forum_komentar.*, s.nama AS nama_siswa, s.foto AS foto_siswa, g.nama_guru, g.foto AS foto_guru, u.nama_lengkap AS nama_admin')
            ->join('rb_siswa s', 'rb_forum_komentar.nisn_nip = s.nisn', 'left')
            ->join('rb_guru g', 'rb_forum_komentar.nisn_nip = g.nip', 'left')
            ->join('rb_users u', 'rb_forum_komentar.nisn_nip = u.id_user', 'left')
            ->where('id_forum_topic', $id)->orderBy('id_forum_komentar', 'ASC')->findAll();

        return view('forum/topik', [
            'judul'    => 'Forum: ' . $topik['judul_topic'],
            'topik'    => $topik,
            'jadwal'   => $jadwal,
            'komentar' => $komentar,
            'kelola'   => $this->bolehKelola(),
        ]);
    }

    public function komentar(int $id): RedirectResponse
    {
        $this->ambilTopik($id);
        $isi = trim((string) $this->request->getPost('isi_komentar'));
        if ($isi !== '') {
            model(ForumKomentarModel::class)->insert([
                'id_forum_topic' => $id,
                'nisn_nip'       => (string) session('id'),
                'isi_komentar'   => $isi,
                'waktu_komentar' => date('Y-m-d H:i:s'),
            ]);
        }

        return redirect()->to(site_url("forum/topik/{$id}") . '#akhir');
    }

    public function hapusKomentar(int $id, int $idKomentar): RedirectResponse
    {
        $this->ambilTopik($id);
        $k = $this->wajibAda(model(ForumKomentarModel::class)->where('id_forum_topic', $id)->find($idKomentar));
        // Guru/admin boleh menghapus semua komentar; siswa hanya komentarnya sendiri.
        if (! $this->bolehKelola() && $k['nisn_nip'] !== session('id')) {
            return $this->gagal(site_url("forum/topik/{$id}"), 'Anda hanya boleh menghapus komentar sendiri.');
        }
        model(ForumKomentarModel::class)->delete($idKomentar);

        return $this->kembali(site_url("forum/topik/{$id}"), 'Komentar dihapus.');
    }

    public function hapusTopik(int $id): RedirectResponse
    {
        $this->wajibBolehUbah();
        [$topik] = $this->ambilTopik($id);
        model(ForumKomentarModel::class)->where('id_forum_topic', $id)->delete();
        model(ForumTopicModel::class)->delete($id);

        return $this->kembali(site_url('forum/' . $topik['kodejdwl']), 'Topik beserta komentarnya dihapus.');
    }

    private function bolehKelola(): bool
    {
        return in_array(level(), ['guru', 'superuser'], true);
    }

    /** @return array{0: array<string, mixed>, 1: array<string, mixed>} */
    private function ambilTopik(int $id): array
    {
        $topik = $this->wajibAda(model(ForumTopicModel::class)->find($id), 'Topik tidak ditemukan.');

        return [$topik, $this->jadwal($topik['kodejdwl'])];
    }
}
