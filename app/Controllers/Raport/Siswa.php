<?php

namespace App\Controllers\Raport;

use App\Controllers\BaseController;
use App\Libraries\DataRaport;
use App\Models\RiwayatKelasModel;
use App\Models\SiswaModel;
use App\Models\TahunAkademikModel;

/** Siswa (atau orang tuanya) melihat nilai raport & UTS. */
class Siswa extends BaseController
{
    public function raport(): string
    {
        return $this->tampilkan('Laporan Nilai Akhir', 'raport/saya', static fn ($nisn, $kelas, $tahun) => DataRaport::nilaiRaport($nisn, $kelas, $tahun));
    }

    public function uts(): string
    {
        return $this->tampilkan('Laporan Nilai UTS', 'raport/uts-saya', static fn ($nisn, $kelas, $tahun) => DataRaport::nilaiUts($nisn, $kelas, $tahun));
    }

    /** NISN siswa yang nilainya dilihat: siswa sendiri, atau anak dari akun orang tua. */
    public static function nisnDilihat(): string
    {
        return (string) (level() === 'ortu' ? session('nisn_anak') : session('id'));
    }

    private function tampilkan(string $judul, string $segmen, callable $ambil): string
    {
        $nisn      = self::nisnDilihat();
        $s         = $this->wajibAda(model(SiswaModel::class)->detail($nisn));
        $kelasOpsi = model(RiwayatKelasModel::class)->kelasPernah($nisn, (string) $s['kode_kelas']);
        $kelas     = (string) $this->request->getGet('kelas');
        $kelas     = isset($kelasOpsi[$kelas]) ? $kelas : (string) $s['kode_kelas'];
        $tahun     = (string) $this->request->getGet('tahun');

        return view('raport/siswa', [
            'judul'     => $judul,
            'segmen'    => $segmen,
            'nama'      => $s['nama'],
            'tahun'     => $tahun,
            'kelas'     => $kelas,
            'kelasOpsi' => $kelasOpsi,
            'tahunOpsi' => pilihan(model(TahunAkademikModel::class)->semua(), 'id_tahun_akademik', 'nama_tahun', '- Pilih Tahun Akademik -'),
            'kelompok'  => $tahun !== '' ? $ambil($nisn, $kelas, $tahun) : [],
            'sekolah'   => config('Sekolah'),
        ]);
    }
}
