<?php

namespace App\Controllers;

use App\Models\JawabanEssaiModel;
use App\Models\JawabanObjektifModel;
use App\Models\KategoriQuizUjianModel;
use App\Models\NilaiPertanyaanEssaiModel;
use App\Models\PertanyaanEssaiModel;
use App\Models\PertanyaanObjektifModel;
use App\Models\QuizUjianModel;
use App\Models\SiswaModel;
use CodeIgniter\HTTP\RedirectResponse;

/** Quiz / ujian online: soal essai & pilihan ganda per jadwal. */
class Quiz extends BaseController
{
    public function index(): string
    {
        return $this->halamanPilihJadwal('Quiz dan Ujian Online', site_url('quiz'), static fn ($r) =>
            '<a class="btn btn-success btn-xs" href="' . site_url('quiz/' . $r['kodejdwl']) . '"><span class="glyphicon glyphicon-th"></span> Tampilkan</a>',
            ['Jumlah' => $this->hitungPerJadwal('rb_quiz_ujian')]);
    }

    public function daftar(int $kodejdwl): string
    {
        return view('quiz/daftar', [
            'judul'  => 'Daftar Quiz dan Ujian Online',
            'jadwal' => $this->jadwal($kodejdwl),
            'baris'  => model(QuizUjianModel::class)
                ->select('rb_quiz_ujian.*, k.kategori_quiz_ujian')
                ->join('rb_kategori_quiz_ujian k', 'rb_quiz_ujian.id_kategori_quiz_ujian = k.id_kategori_quiz_ujian', 'left')
                ->where('kodejdwl', $kodejdwl)->orderBy('id_quiz_ujian', 'ASC')->findAll(),
            'kelola' => in_array(level(), ['guru', 'superuser'], true),
        ]);
    }

    public function tambah(int $kodejdwl): string
    {
        $this->wajibBolehUbah();

        return view('components/form_jadwal', [
            'judul'  => 'Tambah Quiz / Ujian',
            'jadwal' => $this->jadwal($kodejdwl),
            'row'    => [],
            'baru'   => true,
            'action' => site_url("quiz/{$kodejdwl}/tambah"),
            'batal'  => site_url("quiz/{$kodejdwl}"),
            'field'  => [
                ['name' => 'id_kategori_quiz_ujian', 'label' => 'Kategori', 'type' => 'select', 'rules' => 'required',
                    'options' => pilihan(model(KategoriQuizUjianModel::class)->findAll(), 'id_kategori_quiz_ujian', 'kategori_quiz_ujian', '- Pilih Kategori -')],
                ['name' => 'keterangan', 'label' => 'Keterangan', 'rules' => 'required'],
                ['name' => 'batas_waktu', 'label' => 'Batas Waktu', 'type' => 'datetime-local', 'rules' => 'required',
                    'default' => date('Y-m-d\TH:i', strtotime('+60 minutes')), 'help' => 'Setelah batas waktu, siswa tidak bisa lagi menjawab.'],
            ],
        ]);
    }

    public function simpan(int $kodejdwl): RedirectResponse
    {
        $this->wajibBolehUbah();
        $this->jadwal($kodejdwl);
        if (! $this->validate(['id_kategori_quiz_ujian' => 'required|is_natural_no_zero', 'keterangan' => 'required', 'batas_waktu' => 'required'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        model(QuizUjianModel::class)->insert([
            'id_kategori_quiz_ujian' => (int) $this->request->getPost('id_kategori_quiz_ujian'),
            'kodejdwl'               => $kodejdwl,
            'keterangan'             => trim((string) $this->request->getPost('keterangan')),
            'batas_waktu'            => date('Y-m-d H:i:s', strtotime((string) $this->request->getPost('batas_waktu'))),
        ]);

        return $this->kembali(site_url("quiz/{$kodejdwl}"), 'Quiz berhasil ditambahkan.');
    }

    public function hapus(int $kodejdwl, int $id): RedirectResponse
    {
        $this->wajibBolehUbah();
        $this->jadwal($kodejdwl);
        $quiz = $this->wajibAda(model(QuizUjianModel::class)->where('kodejdwl', $kodejdwl)->find($id));

        $this->db->transStart();
        $essai    = array_column(model(PertanyaanEssaiModel::class)->where('id_quiz_ujian', $id)->findAll(), 'id_pertanyaan_essai');
        $objektif = array_column(model(PertanyaanObjektifModel::class)->where('id_quiz_ujian', $id)->findAll(), 'id_pertanyaan_objektif');
        if ($essai !== []) {
            model(JawabanEssaiModel::class)->whereIn('id_pertanyaan_essai', $essai)->delete();
        }
        if ($objektif !== []) {
            model(JawabanObjektifModel::class)->whereIn('id_pertanyaan_objektif', $objektif)->delete();
        }
        model(PertanyaanEssaiModel::class)->where('id_quiz_ujian', $id)->delete();
        model(PertanyaanObjektifModel::class)->where('id_quiz_ujian', $id)->delete();
        model(NilaiPertanyaanEssaiModel::class)->where('id_quiz_ujian', $id)->delete();
        model(QuizUjianModel::class)->delete($quiz['id_quiz_ujian']);
        $this->db->transComplete();

        return $this->kembali(site_url("quiz/{$kodejdwl}"), 'Quiz beserta soal dan jawabannya berhasil dihapus.');
    }

    /** Kelola soal essai & objektif. */
    public function soal(int $id): string
    {
        [$quiz, $jadwal] = $this->quiz($id);

        return view('quiz/soal', [
            'judul'    => 'Soal ' . $quiz['kategori_quiz_ujian'],
            'quiz'     => $quiz,
            'jadwal'   => $jadwal,
            'essai'    => model(PertanyaanEssaiModel::class)->where('id_quiz_ujian', $id)->orderBy('id_pertanyaan_essai', 'ASC')->findAll(),
            'objektif' => model(PertanyaanObjektifModel::class)->where('id_quiz_ujian', $id)->orderBy('id_pertanyaan_objektif', 'ASC')->findAll(),
            'kelola'   => boleh_ubah(),
        ]);
    }

    public function tambahEssai(int $id): RedirectResponse
    {
        $this->wajibBolehUbah();
        $this->quiz($id);
        $soal = trim((string) $this->request->getPost('pertanyaan_essai'));
        if ($soal !== '') {
            model(PertanyaanEssaiModel::class)->insert(['id_quiz_ujian' => $id, 'pertanyaan_essai' => $soal]);
        }

        return $this->kembali(site_url("quiz/soal/{$id}"), 'Soal essai ditambahkan.');
    }

    public function tambahObjektif(int $id): RedirectResponse
    {
        $this->wajibBolehUbah();
        $this->quiz($id);
        if (! $this->validate(['pertanyaan_objektif' => 'required', 'jawab_a' => 'required', 'jawab_b' => 'required', 'kunci_jawaban' => 'required|in_list[a,b,c,d,e]'])) {
            return redirect()->to(site_url("quiz/soal/{$id}"))->withInput()->with('errors', $this->validator->getErrors());
        }

        model(PertanyaanObjektifModel::class)->insert(
            $this->inputPost(['pertanyaan_objektif', 'jawab_a', 'jawab_b', 'jawab_c', 'jawab_d', 'jawab_e', 'kunci_jawaban']) + ['id_quiz_ujian' => $id]
        );

        return $this->kembali(site_url("quiz/soal/{$id}"), 'Soal pilihan ganda ditambahkan.');
    }

    public function hapusEssai(int $id, int $idSoal): RedirectResponse
    {
        $this->wajibBolehUbah();
        $this->quiz($id);
        model(JawabanEssaiModel::class)->where('id_pertanyaan_essai', $idSoal)->delete();
        model(PertanyaanEssaiModel::class)->where('id_quiz_ujian', $id)->delete($idSoal);

        return $this->kembali(site_url("quiz/soal/{$id}"), 'Soal essai dihapus.');
    }

    public function hapusObjektif(int $id, int $idSoal): RedirectResponse
    {
        $this->wajibBolehUbah();
        $this->quiz($id);
        model(JawabanObjektifModel::class)->where('id_pertanyaan_objektif', $idSoal)->delete();
        model(PertanyaanObjektifModel::class)->where('id_quiz_ujian', $id)->delete($idSoal);

        return $this->kembali(site_url("quiz/soal/{$id}"), 'Soal pilihan ganda dihapus.');
    }

    /** Daftar siswa beserta status menjawab dan nilainya. */
    public function jawaban(int $id): string
    {
        [$quiz, $jadwal] = $this->quiz($id);
        $model = model(QuizUjianModel::class);
        $siswa = model(SiswaModel::class)->perKelas($jadwal['kode_kelas']);
        $sudah = array_flip(array_merge(
            array_column($this->db->table('rb_jawaban_objektif a')->select('a.nisn')->join('rb_pertanyaan_objektif b', 'a.id_pertanyaan_objektif = b.id_pertanyaan_objektif')->where('b.id_quiz_ujian', $id)->get()->getResultArray(), 'nisn'),
            array_column($this->db->table('rb_jawaban_essai a')->select('a.nisn')->join('rb_pertanyaan_essai b', 'a.id_pertanyaan_essai = b.id_pertanyaan_essai')->where('b.id_quiz_ujian', $id)->get()->getResultArray(), 'nisn')
        ));
        foreach ($siswa as &$s) {
            $s['sudah'] = isset($sudah[$s['nisn']]);
            $s['nilai'] = $s['sudah'] ? $model->nilai($id, $s['nisn']) : null;
        }

        return view('quiz/jawaban', ['judul' => 'Jawaban Quiz / Ujian', 'quiz' => $quiz, 'jadwal' => $jadwal, 'siswa' => $siswa]);
    }

    public function jawabanSiswa(int $id, string $nisn): string
    {
        [$quiz, $jadwal] = $this->quiz($id);
        $siswa = $this->wajibAda(model(SiswaModel::class)->cariNisn($nisn));

        return view('quiz/jawaban_siswa', [
            'judul'    => 'Jawaban ' . $siswa['nama'],
            'quiz'     => $quiz,
            'jadwal'   => $jadwal,
            'siswa'    => $siswa,
            'nilai'    => model(QuizUjianModel::class)->nilai($id, $nisn),
            'essai'    => $this->essaiDenganJawaban($id, $nisn),
            'objektif' => $this->objektifDenganJawaban($id, $nisn),
        ]);
    }

    public function nilaiEssai(int $id, string $nisn): RedirectResponse
    {
        $this->wajibBolehUbah();
        $this->quiz($id);
        if (! $this->validate(['nilai_essai' => 'required|is_natural|less_than_equal_to[100]'])) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $model = model(NilaiPertanyaanEssaiModel::class);
        $nilai = (int) $this->request->getPost('nilai_essai');
        $lama  = $model->where(['id_quiz_ujian' => $id, 'nisn' => $nisn])->first();
        $lama ? $model->update($lama['id_nilai_pertanyaan_essai'], ['nilai_essai' => $nilai])
              : $model->insert(['id_quiz_ujian' => $id, 'nisn' => $nisn, 'nilai_essai' => $nilai]);

        return $this->kembali(site_url("quiz/soal/{$id}/jawaban/" . rawurlencode($nisn)), 'Nilai essai disimpan.');
    }

    // ------------------------------------------------------------------ Siswa

    public function kerjakan(int $id): string
    {
        [$quiz, $jadwal] = $this->quiz($id);
        $nisn = (string) session('id');

        return view('quiz/kerjakan', [
            'judul'    => 'Kerjakan ' . $quiz['kategori_quiz_ujian'],
            'quiz'     => $quiz,
            'jadwal'   => $jadwal,
            'habis'    => QuizUjianModel::waktuHabis($quiz),
            'essai'    => $this->essaiDenganJawaban($id, $nisn),
            'objektif' => $this->objektifDenganJawaban($id, $nisn),
        ]);
    }

    public function simpanObjektif(int $id): RedirectResponse
    {
        [$quiz] = $this->quiz($id);
        if (QuizUjianModel::waktuHabis($quiz)) {
            return $this->gagal(site_url("quiz/soal/{$id}/kerjakan"), 'Waktu sudah habis, jawaban tidak disimpan.');
        }

        $nisn  = (string) session('id');
        $soal  = array_column(model(PertanyaanObjektifModel::class)->where('id_quiz_ujian', $id)->findAll(), null, 'id_pertanyaan_objektif');
        $model = model(JawabanObjektifModel::class);
        foreach ((array) $this->request->getPost('jawaban') as $idSoal => $jawab) {
            if (! isset($soal[$idSoal]) || ! in_array($jawab, ['a', 'b', 'c', 'd', 'e'], true)) {
                continue;
            }
            $lama = $model->where(['id_pertanyaan_objektif' => $idSoal, 'nisn' => $nisn])->first();
            $lama ? $model->update($lama['id_jawaban_objektif'], ['jawaban' => $jawab])
                  : $model->insert(['nisn' => $nisn, 'id_pertanyaan_objektif' => $idSoal, 'jawaban' => $jawab]);
        }

        return $this->kembali(site_url("quiz/soal/{$id}/kerjakan"), 'Jawaban pilihan ganda disimpan.');
    }

    public function jawabEssai(int $id, int $idSoal): string
    {
        [$quiz, $jadwal] = $this->quiz($id);
        $soal  = $this->wajibAda(model(PertanyaanEssaiModel::class)->where('id_quiz_ujian', $id)->find($idSoal));
        $jawab = model(JawabanEssaiModel::class)->where(['id_pertanyaan_essai' => $idSoal, 'nisn' => session('id')])->first();

        return view('quiz/jawab_essai', ['judul' => 'Jawab Soal Essai', 'quiz' => $quiz, 'jadwal' => $jadwal, 'soal' => $soal, 'jawab' => $jawab]);
    }

    public function simpanEssai(int $id, int $idSoal): RedirectResponse
    {
        [$quiz] = $this->quiz($id);
        $this->wajibAda(model(PertanyaanEssaiModel::class)->where('id_quiz_ujian', $id)->find($idSoal));
        if (QuizUjianModel::waktuHabis($quiz)) {
            return $this->gagal(site_url("quiz/soal/{$id}/kerjakan"), 'Waktu sudah habis, jawaban tidak disimpan.');
        }

        $nisn  = (string) session('id');
        $isi   = trim((string) $this->request->getPost('jawaban_essai'));
        $model = model(JawabanEssaiModel::class);
        $lama  = $model->where(['id_pertanyaan_essai' => $idSoal, 'nisn' => $nisn])->first();
        $lama ? $model->update($lama['id_jawaban_essai'], ['jawaban_essai' => $isi])
              : $model->insert(['nisn' => $nisn, 'id_pertanyaan_essai' => $idSoal, 'jawaban_essai' => $isi]);

        return $this->kembali(site_url("quiz/soal/{$id}/kerjakan"), 'Jawaban essai disimpan.');
    }

    // ------------------------------------------------------------------ Bantuan

    /** @return array{0: array<string, mixed>, 1: array<string, mixed>} quiz & jadwal (dengan cek akses) */
    private function quiz(int $id): array
    {
        $quiz = $this->wajibAda(model(QuizUjianModel::class)->detail($id), 'Quiz tidak ditemukan.');

        return [$quiz, $this->jadwal($quiz['kodejdwl'])];
    }

    /** @return list<array<string, mixed>> */
    private function essaiDenganJawaban(int $id, string $nisn): array
    {
        $soal  = model(PertanyaanEssaiModel::class)->where('id_quiz_ujian', $id)->orderBy('id_pertanyaan_essai', 'ASC')->findAll();
        $jawab = $soal === [] ? [] : array_column(
            model(JawabanEssaiModel::class)->where('nisn', $nisn)->whereIn('id_pertanyaan_essai', array_column($soal, 'id_pertanyaan_essai'))->findAll(),
            'jawaban_essai',
            'id_pertanyaan_essai'
        );
        foreach ($soal as &$s) {
            $s['jawaban'] = $jawab[$s['id_pertanyaan_essai']] ?? '';
        }

        return $soal;
    }

    /** @return list<array<string, mixed>> */
    private function objektifDenganJawaban(int $id, string $nisn): array
    {
        $soal  = model(PertanyaanObjektifModel::class)->where('id_quiz_ujian', $id)->orderBy('id_pertanyaan_objektif', 'ASC')->findAll();
        $jawab = $soal === [] ? [] : array_column(
            model(JawabanObjektifModel::class)->where('nisn', $nisn)->whereIn('id_pertanyaan_objektif', array_column($soal, 'id_pertanyaan_objektif'))->findAll(),
            'jawaban',
            'id_pertanyaan_objektif'
        );
        foreach ($soal as &$s) {
            $s['jawaban'] = strtolower((string) ($jawab[$s['id_pertanyaan_objektif']] ?? ''));
        }

        return $soal;
    }
}
