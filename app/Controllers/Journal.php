<?php

namespace App\Controllers;

use App\Models\JournalListModel;
use CodeIgniter\HTTP\RedirectResponse;

/** Journal Kegiatan Belajar Mengajar per jadwal. */
class Journal extends BaseController
{
    /** Guru: pilih dari jadwal yang diampu. */
    public function index(): string
    {
        return $this->halamanPilihJadwal('Journal Kegiatan Belajar Mengajar', site_url('journal'), $this->tombol());
    }

    /** Admin & kepala: pilih kelas + tahun akademik. */
    public function semua(): string
    {
        return $this->halamanPilihJadwal('Journal Kegiatan Belajar Mengajar', site_url('journal-kbm'), $this->tombol());
    }

    public function daftar(int $kodejdwl): string
    {
        return view('journal/daftar', [
            'judul'  => 'Journal Kegiatan Belajar Mengajar',
            'jadwal' => $this->jadwal($kodejdwl),
            'baris'  => model(JournalListModel::class)->where('kodejdwl', $kodejdwl)->orderBy('tanggal', 'DESC')->orderBy('id_journal', 'DESC')->findAll(),
        ]);
    }

    public function tambah(int $kodejdwl): string
    {
        $this->wajibBolehUbah();
        $jadwal = $this->jadwal($kodejdwl);
        $jamKe  = model(JournalListModel::class)->where('kodejdwl', $kodejdwl)->countAllResults() + 1;

        return $this->form($jadwal, ['hari' => hari_ini(), 'tanggal' => date('Y-m-d'), 'jam_ke' => $jamKe], site_url("journal/{$kodejdwl}/tambah"), true);
    }

    public function simpan(int $kodejdwl): RedirectResponse
    {
        $this->wajibBolehUbah();
        $this->jadwal($kodejdwl);
        if (! $this->validate($this->aturan())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        model(JournalListModel::class)->insert($this->input() + [
            'kodejdwl'    => $kodejdwl,
            'waktu_input' => date('Y-m-d H:i:s'),
            'users'       => (string) session('id'),
        ]);

        return $this->kembali(site_url("journal/{$kodejdwl}"), 'Journal berhasil ditambahkan.');
    }

    public function edit(int $kodejdwl, int $id): string
    {
        $this->wajibBolehUbah();
        $jadwal = $this->jadwal($kodejdwl);
        $row    = $this->wajibAda(model(JournalListModel::class)->where('kodejdwl', $kodejdwl)->find($id));

        return $this->form($jadwal, $row, site_url("journal/{$kodejdwl}/edit/{$id}"), false);
    }

    public function update(int $kodejdwl, int $id): RedirectResponse
    {
        $this->wajibBolehUbah();
        $this->jadwal($kodejdwl);
        $this->wajibAda(model(JournalListModel::class)->where('kodejdwl', $kodejdwl)->find($id));
        if (! $this->validate($this->aturan())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        model(JournalListModel::class)->update($id, $this->input() + ['users' => (string) session('id')]);

        return $this->kembali(site_url("journal/{$kodejdwl}"), 'Journal berhasil diperbarui.');
    }

    public function hapus(int $kodejdwl, int $id): RedirectResponse
    {
        $this->wajibBolehUbah();
        $this->jadwal($kodejdwl);
        model(JournalListModel::class)->where('kodejdwl', $kodejdwl)->delete($id);

        return $this->kembali(site_url("journal/{$kodejdwl}"), 'Journal berhasil dihapus.');
    }

    private function tombol(): callable
    {
        return static fn ($r) => '<a class="btn btn-success btn-xs" href="' . site_url('journal/' . $r['kodejdwl']) . '"><span class="glyphicon glyphicon-search"></span> Lihat Journal</a>';
    }

    private function form(array $jadwal, array $row, string $action, bool $baru): string
    {
        return view('components/form_jadwal', [
            'judul'  => ($baru ? 'Tambah' : 'Edit') . ' Journal KBM',
            'jadwal' => $jadwal,
            'row'    => $row,
            'action' => $action,
            'baru'   => $baru,
            'batal'  => site_url('journal/' . $jadwal['kodejdwl']),
            'field'  => [
                ['name' => 'hari', 'label' => 'Hari', 'type' => 'select', 'options' => array_combine(daftar_hari(), daftar_hari())],
                ['name' => 'tanggal', 'label' => 'Tanggal', 'type' => 'date', 'rules' => 'required'],
                ['name' => 'jam_ke', 'label' => 'Jam Ke', 'rules' => 'required'],
                ['name' => 'materi', 'label' => 'Materi', 'type' => 'textarea', 'rows' => 3, 'rules' => 'required'],
                ['name' => 'keterangan', 'label' => 'Keterangan', 'type' => 'textarea', 'rows' => 6],
            ],
        ]);
    }

    /** @return array<string, string> */
    private function aturan(): array
    {
        return ['tanggal' => 'required|valid_date[Y-m-d]', 'jam_ke' => 'required|max_length[50]', 'materi' => 'required'];
    }

    /** @return array<string, string> */
    private function input(): array
    {
        return $this->inputPost(['hari', 'tanggal', 'jam_ke', 'materi', 'keterangan']);
    }
}
