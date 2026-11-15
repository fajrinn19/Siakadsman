<?php

namespace App\Controllers\Raport;

use App\Controllers\BaseController;
use App\Libraries\DataRaport;
use App\Models\TahunAkademikModel;

/** Siswa melihat nilai raport & UTS miliknya. */
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

    private function tampilkan(string $judul, string $segmen, callable $ambil): string
    {
        $nisn  = (string) session('id');
        $kelas = (string) session('kode_kelas');
        $tahun = (string) $this->request->getGet('tahun');

        return view('raport/siswa', [
            'judul'     => $judul,
            'segmen'    => $segmen,
            'tahun'     => $tahun,
            'tahunOpsi' => pilihan(model(TahunAkademikModel::class)->semua(), 'id_tahun_akademik', 'nama_tahun', '- Pilih Tahun Akademik -'),
            'kelompok'  => $tahun !== '' ? $ambil($nisn, $kelas, $tahun) : [],
            'sekolah'   => config('Sekolah'),
        ]);
    }
}
