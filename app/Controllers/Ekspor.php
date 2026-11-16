<?php

namespace App\Controllers;

use App\Controllers\Raport\PerKelas;
use App\Libraries\DataRaport;
use App\Libraries\Excel;
use App\Models\SiswaModel;
use CodeIgniter\HTTP\ResponseInterface;

/** Ekspor rekap nilai raport & absensi ke Excel. */
class Ekspor extends PerKelas
{
    /** Nilai raport satu kelas: satu baris per siswa, kolom per mata pelajaran (pengetahuan & keterampilan). */
    public function nilai(): ResponseInterface
    {
        $f = $this->filterKelas();
        if (! $f['lengkap']) {
            return redirect()->to(site_url('raport/cetak'))->with('error', 'Pilih tahun akademik dan kelas dulu.');
        }

        $header = ['No', 'NISN', 'Nama'];
        $baris  = [];
        foreach ($f['siswa'] as $i => $s) {
            $row = [$i + 1, (string) $s['nisn'], $s['nama']];
            foreach (DataRaport::nilaiRaport($s['nisn'], $f['kelas'], $f['tahun']) as $kel) {
                foreach ($kel['mapel'] as $m) {
                    if ($i === 0) {
                        $header[] = $m['namamatapelajaran'] . ' (P)';
                        $header[] = $m['namamatapelajaran'] . ' (K)';
                    }
                    $row[] = $m['pengetahuan'] !== null ? round($m['pengetahuan']) : '';
                    $row[] = $m['keterampilan'] !== null ? round($m['keterampilan']) : '';
                }
            }
            $baris[] = $row;
        }

        $judul = ['Rekap Nilai Raport Kelas ' . $f['kelas'] . ' — Tahun Akademik ' . $f['tahun'], 'P = Pengetahuan, K = Keterampilan'];

        return Excel::unduh(Excel::buat('Nilai ' . $f['kelas'], $header, $baris, $judul), "nilai_{$f['kelas']}_{$f['tahun']}.xlsx");
    }

    /** Rekap absensi satu jadwal pelajaran. */
    public function absensi(int $kodejdwl): ResponseInterface
    {
        $jadwal = $this->jadwal($kodejdwl);
        $hitung = [];
        foreach ($this->db->table('rb_absensi_siswa')->select('nisn, kode_kehadiran, COUNT(*) AS total')->where('kodejdwl', $kodejdwl)
            ->groupBy('nisn, kode_kehadiran')->get()->getResultArray() as $h) {
            $hitung[$h['nisn']][$h['kode_kehadiran']] = (int) $h['total'];
        }
        $pertemuan = $this->db->table('rb_absensi_siswa')->select('tanggal')->distinct()->where('kodejdwl', $kodejdwl)->countAllResults();

        $baris = [];
        foreach (model(SiswaModel::class)->perKelas($jadwal['kode_kelas']) as $i => $s) {
            $h       = $hitung[$s['nisn']] ?? [];
            $baris[] = [$i + 1, (string) $s['nisn'], $s['nama'], $pertemuan, $h['H'] ?? 0, $h['S'] ?? 0, $h['I'] ?? 0, $h['A'] ?? 0,
                $pertemuan > 0 ? round(($h['H'] ?? 0) / $pertemuan * 100, 2) : 0];
        }

        return Excel::unduh(Excel::buat('Absensi', ['No', 'NISN', 'Nama', 'Pertemuan', 'Hadir', 'Sakit', 'Izin', 'Alpa', '% Hadir'], $baris,
            ['Rekap Absensi ' . $jadwal['namamatapelajaran'] . ' — ' . $jadwal['nama_kelas'], 'Guru: ' . $jadwal['nama_guru']]),
            "absensi_{$jadwal['kode_kelas']}_{$jadwal['kode_pelajaran']}.xlsx");
    }
}
