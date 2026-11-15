<?php

namespace App\Controllers\Raport;

use App\Libraries\DataRaport;
use App\Models\NilaiExtrakulikulerModel;
use App\Models\NilaiPrestasiModel;
use App\Models\NilaiSikapSemesterModel;
use App\Models\PredikatModel;
use CodeIgniter\Exceptions\PageNotFoundException;

/** Daftar siswa untuk cetak raport dan halaman-halaman cetaknya. */
class Cetak extends PerKelas
{
    private const HALAMAN = ['cover', '1', '2', '3', '4', '5', '6'];

    public function index(): string
    {
        return view('raport/cetak_daftar', ['judul' => 'Cetak Raport Semester', 'segmen' => 'raport/cetak', 'uts' => false] + $this->filterKelas());
    }

    public function uts(): string
    {
        return view('raport/cetak_daftar', ['judul' => 'Cetak Raport UTS', 'segmen' => 'raport/cetak-uts', 'uts' => true] + $this->filterKelas());
    }

    public function halaman(string $hal, string $nisn): string
    {
        if (! in_array($hal, self::HALAMAN, true)) {
            throw PageNotFoundException::forPageNotFound();
        }
        $d = $this->data($nisn);

        $d += match ($hal) {
            '2'     => ['masuk' => model(\App\Models\RiwayatKelasModel::class)->diterima($nisn)],
            '3'     => ['sikap' => model(NilaiSikapSemesterModel::class)->where(['id_tahun_akademik' => $d['tahun'], 'nisn' => $nisn, 'kode_kelas' => $d['kelas']])->first() ?? []],
            '4', '5' => ['kelompok' => DataRaport::nilaiRaport($nisn, $d['kelas'], $d['tahun']), 'predikat' => model(PredikatModel::class)->untukKelas($d['kelas'])],
            '6'     => [
                'ekstra'   => model(NilaiExtrakulikulerModel::class)->where(['id_tahun_akademik' => $d['tahun'], 'nisn' => $nisn, 'kode_kelas' => $d['kelas']])->findAll(),
                'prestasi' => model(NilaiPrestasiModel::class)->where(['id_tahun_akademik' => $d['tahun'], 'nisn' => $nisn, 'kode_kelas' => $d['kelas']])->findAll(),
                'absen'    => DataRaport::ketidakhadiran($nisn, $d['kelas'], $d['tahun']),
            ],
            default => [],
        };

        return view('raport/print/hal_' . $hal, $d);
    }

    public function printUts(string $nisn): string
    {
        $d = $this->data($nisn);

        return view('raport/print/uts', $d + [
            'kelompok' => DataRaport::nilaiUts($nisn, $d['kelas'], $d['tahun']),
            'predikat' => model(PredikatModel::class)->untukKelas($d['kelas']),
        ]);
    }

    /** Data umum halaman cetak: siswa, kelas, tahun akademik, identitas sekolah. */
    private function data(string $nisn): array
    {
        $s     = $this->wajibAda(DataRaport::siswa($nisn), 'Siswa tidak ditemukan.');
        $tahun = (string) $this->request->getGet('tahun');
        $kelas = (string) ($this->request->getGet('kelas') ?: $s['kode_kelas']);

        // Guru hanya boleh mencetak raport siswa di kelas yang diajarnya / diwalikannya.
        if (level() === 'guru' && ! $this->guruTerkaitKelas($kelas)) {
            throw PageNotFoundException::forPageNotFound('Anda tidak mengajar di kelas ini.');
        }

        return [
            'judul'     => 'Raport ' . $s['nama'] . ' - ' . $s['nisn'],
            's'         => $s,
            'kelas'     => $kelas,
            'tahun'     => $tahun,
            't'         => DataRaport::tahun($tahun) ?? ['keterangan' => '', 'nama_tahun' => ''],
            'semester'  => $tahun !== '' ? semester_dari_tahun($tahun) : '',
            'iden'      => DataRaport::identitas(),
            'sekolah'   => config('Sekolah'),
            'wali'      => ['nama' => $s['walikelas'], 'nip' => $s['nip_wali']],
        ];
    }

    private function guruTerkaitKelas(string $kelas): bool
    {
        $nip = (string) session('id');

        return $this->db->table('rb_jadwal_pelajaran')->where(['kode_kelas' => $kelas, 'nip' => $nip])->countAllResults() > 0
            || $this->db->table('rb_kelas')->where(['kode_kelas' => $kelas, 'nip' => $nip])->countAllResults() > 0;
    }
}
