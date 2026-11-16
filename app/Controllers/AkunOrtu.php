<?php

namespace App\Controllers;

use App\Libraries\Password;
use App\Models\KelasModel;
use App\Models\OrtuModel;
use App\Models\SiswaModel;
use CodeIgniter\HTTP\RedirectResponse;

/** Admin mengelola akun portal orang tua (satu akun per siswa). */
class AkunOrtu extends BaseController
{
    public function index(): string
    {
        $kelas = (string) $this->request->getGet('kelas');
        $siswa = $kelas !== '' ? model(SiswaModel::class)->perKelas($kelas) : [];
        $akun  = $siswa === [] ? [] : array_column(model(OrtuModel::class)->whereIn('nisn', array_column($siswa, 'nisn'))->findAll(), null, 'nisn');

        return view('ortu/kelola', [
            'judul'     => 'Akun Orang Tua',
            'kelas'     => $kelas,
            'kelasOpsi' => model(KelasModel::class)->opsi(),
            'siswa'     => $siswa,
            'akun'      => $akun,
        ]);
    }

    /** Buat akun untuk satu siswa (nisn dikirim) atau semua siswa di kelas yang belum punya akun. */
    public function buat(): RedirectResponse
    {
        $this->wajibBolehUbah();
        $kelas = (string) $this->request->getPost('kelas');
        $nisn  = (string) $this->request->getPost('nisn');
        $daftar = $nisn !== ''
            ? array_filter([model(SiswaModel::class)->cariNisn($nisn)])
            : model(SiswaModel::class)->where('kode_kelas', $kelas)->findAll();

        $dibuat = 0;
        foreach ($daftar as $s) {
            if (model(OrtuModel::class)->where('nisn', $s['nisn'])->countAllResults() > 0) {
                continue;
            }
            model(OrtuModel::class)->insert([
                'nisn'     => $s['nisn'],
                'username' => 'ortu' . $s['nisn'],
                'password' => Password::hash($s['nisn']),
                'nama'     => $s['nama_ayah'] ?: ($s['nama_ibu'] ?: 'Orang tua ' . $s['nama']),
                'no_hp'    => $s['no_telpon_ayah'] ?: $s['no_telpon_ibu'],
                'aktif'    => 'Ya',
                'waktu'    => date('Y-m-d H:i:s'),
            ]);
            $dibuat++;
        }

        return $this->kembali(site_url('akun-ortu') . '?kelas=' . rawurlencode($kelas),
            "{$dibuat} akun orang tua dibuat. Username: ortu + NISN anak, password awal: NISN anak (wajib diganti saat login pertama).");
    }

    public function reset(int $id): RedirectResponse
    {
        $this->wajibBolehUbah();
        $a = $this->wajibAda(model(OrtuModel::class)->find($id));
        model(OrtuModel::class)->update($id, ['password' => Password::hash($a['nisn']), 'aktif' => 'Ya']);

        return redirect()->back()->with('sukses', "Password akun {$a['username']} dikembalikan ke NISN anak.");
    }

    public function hapus(int $id): RedirectResponse
    {
        $this->wajibBolehUbah();
        $a = $this->wajibAda(model(OrtuModel::class)->find($id));
        model(OrtuModel::class)->delete($id);

        return redirect()->back()->with('sukses', "Akun {$a['username']} dihapus.");
    }
}
