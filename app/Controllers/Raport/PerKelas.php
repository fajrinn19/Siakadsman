<?php

namespace App\Controllers\Raport;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use App\Models\RiwayatKelasModel;
use App\Models\SiswaModel;
use App\Models\TahunAkademikModel;

/**
 * Dasar halaman raport yang difilter per tahun akademik + kelas
 * (capaian sikap semester, ekstrakurikuler, prestasi, cetak raport).
 */
abstract class PerKelas extends BaseController
{
    /** @return array{tahun: string, kelas: string, lengkap: bool, tahunOpsi: array, kelasOpsi: array, siswa: list<array>} */
    protected function filterKelas(): array
    {
        $tahun = (string) ($this->request->getGetPost('tahun') ?? '');
        $kelas = (string) ($this->request->getGetPost('kelas') ?? '');
        $siap  = $tahun !== '' && $kelas !== '';

        return [
            'tahun'     => $tahun,
            'kelas'     => $kelas,
            'lengkap'   => $siap,
            'tahunOpsi' => pilihan(model(TahunAkademikModel::class)->semua(), 'id_tahun_akademik', 'nama_tahun', '- Pilih Tahun Akademik -'),
            'kelasOpsi' => model(KelasModel::class)->opsi(),
            'siswa'     => $siap ? $this->anggotaKelas($kelas) : [],
        ];
    }

    protected function urlFilter(string $segmen, string $tahun, string $kelas, string $jangkar = ''): string
    {
        return site_url($segmen) . '?' . http_build_query(compact('tahun', 'kelas')) . ($jangkar !== '' ? '#' . $jangkar : '');
    }

    /**
     * Siswa kelas ini ditambah siswa yang dulu pernah di kelas ini (menurut riwayat kelas),
     * agar raport semester lalu tetap bisa diisi & dicetak setelah siswa naik/pindah kelas.
     *
     * @return list<array<string, mixed>>
     */
    protected function anggotaKelas(string $kelas): array
    {
        $siswa  = model(SiswaModel::class)->perKelas($kelas);
        $mantan = model(RiwayatKelasModel::class)->mantanAnggota($kelas);
        if ($mantan !== []) {
            foreach (model(SiswaModel::class)->lengkap()->whereIn('rb_siswa.nisn', $mantan)->orderBy('rb_siswa.nama', 'ASC')->findAll() as $m) {
                $m['mantan'] = true;
                $siswa[]     = $m;
            }
        }

        return $siswa;
    }
}
