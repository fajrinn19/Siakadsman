<?php

namespace App\Controllers;

use App\Models\KompetensiDasarModel;
use CodeIgniter\HTTP\RedirectResponse;

/** Kompetensi dasar (indikator) per jadwal pelajaran. */
class KompetensiDasar extends BaseController
{
    private const RANAH = ['pengetahuan' => 'Pengetahuan', 'keterampilan' => 'Keterampilan', 'sikap' => 'Sikap'];

    public function index(): string
    {
        return $this->halamanPilihJadwal('Kompetensi Dasar', site_url('kompetensi-dasar'), static fn ($r) =>
            '<a class="btn btn-success btn-xs" href="' . site_url('kompetensi-dasar/' . $r['kodejdwl']) . '"><span class="glyphicon glyphicon-search"></span> Lihat Indikator</a>',
            ['Jumlah KD' => $this->hitungPerJadwal('rb_kompetensi_dasar')]);
    }

    public function daftar(int $kodejdwl): string
    {
        return view('kompetensi/daftar', [
            'judul'  => 'Kompetensi Dasar',
            'jadwal' => $this->jadwal($kodejdwl),
            'baris'  => model(KompetensiDasarModel::class)->where('kodejdwl', $kodejdwl)->orderBy('id_kompetensi_dasar', 'DESC')->findAll(),
        ]);
    }

    public function tambah(int $kodejdwl): string
    {
        $this->wajibBolehUbah();

        return $this->form($this->jadwal($kodejdwl), [], site_url("kompetensi-dasar/{$kodejdwl}/tambah"), true);
    }

    public function simpan(int $kodejdwl): RedirectResponse
    {
        $this->wajibBolehUbah();
        $this->jadwal($kodejdwl);
        if (! $this->validate($this->aturan())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        model(KompetensiDasarModel::class)->insert($this->inputPost(['ranah', 'kompetensi_dasar']) + ['kodejdwl' => $kodejdwl, 'waktu_input' => date('Y-m-d H:i:s')]);

        return $this->kembali(site_url("kompetensi-dasar/{$kodejdwl}"), 'Kompetensi dasar berhasil ditambahkan.');
    }

    public function edit(int $kodejdwl, int $id): string
    {
        $this->wajibBolehUbah();
        $jadwal = $this->jadwal($kodejdwl);
        $row    = $this->wajibAda(model(KompetensiDasarModel::class)->where('kodejdwl', $kodejdwl)->find($id));

        return $this->form($jadwal, $row, site_url("kompetensi-dasar/{$kodejdwl}/edit/{$id}"), false);
    }

    public function update(int $kodejdwl, int $id): RedirectResponse
    {
        $this->wajibBolehUbah();
        $this->jadwal($kodejdwl);
        $this->wajibAda(model(KompetensiDasarModel::class)->where('kodejdwl', $kodejdwl)->find($id));
        if (! $this->validate($this->aturan())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        model(KompetensiDasarModel::class)->update($id, $this->inputPost(['ranah', 'kompetensi_dasar']));

        return $this->kembali(site_url("kompetensi-dasar/{$kodejdwl}"), 'Kompetensi dasar berhasil diperbarui.');
    }

    public function hapus(int $kodejdwl, int $id): RedirectResponse
    {
        $this->wajibBolehUbah();
        $this->jadwal($kodejdwl);
        model(KompetensiDasarModel::class)->where('kodejdwl', $kodejdwl)->delete($id);

        return $this->kembali(site_url("kompetensi-dasar/{$kodejdwl}"), 'Kompetensi dasar berhasil dihapus.');
    }

    private function form(array $jadwal, array $row, string $action, bool $baru): string
    {
        return view('components/form_jadwal', [
            'judul'  => ($baru ? 'Tambah' : 'Edit') . ' Kompetensi Dasar',
            'jadwal' => $jadwal,
            'row'    => $row,
            'action' => $action,
            'baru'   => $baru,
            'batal'  => site_url('kompetensi-dasar/' . $jadwal['kodejdwl']),
            'field'  => [
                ['name' => 'ranah', 'label' => 'Ranah', 'type' => 'select', 'rules' => 'required', 'options' => ['' => '- Pilih -'] + self::RANAH],
                ['name' => 'kompetensi_dasar', 'label' => 'Kompetensi Dasar', 'type' => 'textarea', 'rows' => 3, 'rules' => 'required'],
            ],
        ]);
    }

    /** @return array<string, string> */
    private function aturan(): array
    {
        return ['ranah' => 'required|in_list[pengetahuan,keterampilan,sikap]', 'kompetensi_dasar' => 'required'];
    }
}
