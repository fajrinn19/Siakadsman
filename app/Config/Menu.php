<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Menu sidebar per level pengguna.
 *
 * Setiap item: ['label', 'icon', 'url'] atau ['label', 'icon', 'children' => [...]].
 */
class Menu extends BaseConfig
{
    /** @var array<string, string> */
    public array $labelLevel = [
        'superuser' => 'Administrator',
        'kepala'    => 'Kepala Sekolah',
        'guru'      => 'Guru / Pengajar',
        'siswa'     => 'Siswa / Murid',
    ];

    /**
     * @return list<array<string, mixed>>
     */
    public function untuk(string $level): array
    {
        return match ($level) {
            'superuser' => $this->admin(),
            'kepala'    => $this->kepala(),
            'guru'      => $this->guru(),
            'siswa'     => $this->siswa(),
            default     => [],
        };
    }

    /** @return list<array<string, mixed>> */
    private function admin(): array
    {
        return [
            ['label' => 'Dashboard', 'icon' => 'fa-dashboard', 'url' => '/'],
            ['label' => 'Data Master', 'icon' => 'fa-th', 'children' => [
                ['label' => 'Identitas Sekolah', 'url' => 'identitas'],
                ['label' => 'Kurikulum', 'url' => 'kurikulum'],
                ['label' => 'Tahun Akademik', 'url' => 'tahun-akademik'],
                ['label' => 'Gedung', 'url' => 'gedung'],
                ['label' => 'Ruangan', 'url' => 'ruangan'],
                ['label' => 'Golongan', 'url' => 'golongan'],
                ['label' => 'Jenis PTK', 'url' => 'jenis-ptk'],
                ['label' => 'Jurusan', 'url' => 'jurusan'],
                ['label' => 'Kelas', 'url' => 'kelas'],
                ['label' => 'Status Kepegawaian', 'url' => 'status-kepegawaian'],
            ]],
            ['label' => 'Data Pengguna', 'icon' => 'fa-user', 'children' => [
                ['label' => 'Siswa', 'url' => 'siswa'],
                ['label' => 'Guru', 'url' => 'guru'],
                ['label' => 'Kepala Sekolah', 'url' => 'kepala-sekolah'],
                ['label' => 'Administrator', 'url' => 'admin'],
            ]],
            ['label' => 'Data Akademik', 'icon' => 'fa-tag', 'children' => [
                ['label' => 'Kelompok Mapel', 'url' => 'kelompok-mapel'],
                ['label' => 'Mata Pelajaran', 'url' => 'mata-pelajaran'],
                ['label' => 'Jadwal Pelajaran', 'url' => 'jadwal-pelajaran'],
                ['label' => 'Kompetensi Dasar', 'url' => 'kompetensi-dasar'],
                ['label' => 'Penilaian Diri', 'url' => 'penilaian-diri'],
                ['label' => 'Rentang Nilai', 'url' => 'predikat'],
                ['label' => 'Penilaian Teman', 'url' => 'penilaian-teman'],
            ]],
            ['label' => 'Data Absensi', 'icon' => 'fa-th-large', 'children' => [
                ['label' => 'Absensi Guru', 'url' => 'absensi-guru'],
                ['label' => 'Absensi Siswa', 'url' => 'absensi-siswa'],
                ['label' => 'Rekap Absensi Siswa', 'url' => 'absensi-siswa/rekap'],
            ]],
            ['label' => 'Journal KBM', 'icon' => 'fa-tags', 'url' => 'journal-kbm'],
            ['label' => 'Bahan & Tugas', 'icon' => 'fa-download', 'url' => 'bahan-tugas'],
            ['label' => 'Quiz / Ujian Online', 'icon' => 'fa-pencil-square-o', 'url' => 'quiz'],
            ['label' => 'Forum Diskusi', 'icon' => 'fa-th-list', 'url' => 'forum'],
            ['label' => 'Laporan Nilai Siswa', 'icon' => 'fa-calendar', 'children' => [
                ['label' => 'Data Nilai UTS', 'url' => 'nilai-uts'],
                ['label' => 'Cetak Raport UTS', 'url' => 'raport/cetak-uts'],
                ['label' => 'Capaian Belajar', 'url' => 'raport/capaian'],
                ['label' => 'Ekstrakurikuler', 'url' => 'raport/ekstrakurikuler'],
                ['label' => 'Prestasi', 'url' => 'raport/prestasi'],
                ['label' => 'Data Nilai Raport', 'url' => 'nilai'],
                ['label' => 'Cetak Raport', 'url' => 'raport/cetak'],
            ]],
        ];
    }

    /** @return list<array<string, mixed>> */
    private function kepala(): array
    {
        return [
            ['label' => 'Dashboard', 'icon' => 'fa-dashboard', 'url' => '/'],
            ['label' => 'Data Pengguna', 'icon' => 'fa-user', 'children' => [
                ['label' => 'Siswa', 'url' => 'siswa'],
                ['label' => 'Guru', 'url' => 'guru'],
                ['label' => 'Kepala Sekolah', 'url' => 'kepala-sekolah'],
            ]],
            ['label' => 'Data Master', 'icon' => 'fa-th', 'children' => [
                ['label' => 'Kelas', 'url' => 'kelas'],
                ['label' => 'Mata Pelajaran', 'url' => 'mata-pelajaran'],
                ['label' => 'Jadwal Pelajaran', 'url' => 'jadwal-pelajaran'],
            ]],
            ['label' => 'Data Absensi', 'icon' => 'fa-th-large', 'children' => [
                ['label' => 'Absensi Siswa', 'url' => 'absensi-siswa'],
                ['label' => 'Absensi Guru', 'url' => 'absensi-guru'],
                ['label' => 'Rekap Absensi Siswa', 'url' => 'absensi-siswa/rekap'],
            ]],
            ['label' => 'Journal KBM', 'icon' => 'fa-tags', 'url' => 'journal-kbm'],
            ['label' => 'Forum Diskusi', 'icon' => 'fa-th-list', 'url' => 'forum'],
            ['label' => 'Laporan Nilai', 'icon' => 'fa-calendar', 'url' => 'raport/cetak'],
        ];
    }

    /** @return list<array<string, mixed>> */
    private function guru(): array
    {
        return [
            ['label' => 'Dashboard', 'icon' => 'fa-dashboard', 'url' => '/'],
            ['label' => 'Bahan & Tugas', 'icon' => 'fa-download', 'url' => 'bahan-tugas'],
            ['label' => 'Quiz / Ujian Online', 'icon' => 'fa-pencil-square-o', 'url' => 'quiz'],
            ['label' => 'Absensi Siswa', 'icon' => 'fa-calendar-check-o', 'children' => [
                ['label' => 'Input Absensi', 'url' => 'absensi-siswa'],
                ['label' => 'Rekap Absensi', 'url' => 'absensi-siswa/rekap'],
            ]],
            ['label' => 'Forum Diskusi', 'icon' => 'fa-th-list', 'url' => 'forum'],
            ['label' => 'Kompetensi Dasar', 'icon' => 'fa-tags', 'url' => 'kompetensi-dasar'],
            ['label' => 'Journal KBM', 'icon' => 'fa-list', 'url' => 'journal'],
            ['label' => 'Laporan Nilai Siswa', 'icon' => 'fa-calendar', 'children' => [
                ['label' => 'Input Nilai UTS', 'url' => 'nilai-uts'],
                ['label' => 'Input Nilai Raport', 'url' => 'nilai'],
                ['label' => 'Cetak Raport Siswa', 'url' => 'raport/cetak'],
            ]],
        ];
    }

    /** @return list<array<string, mixed>> */
    private function siswa(): array
    {
        return [
            ['label' => 'Dashboard', 'icon' => 'fa-dashboard', 'url' => '/'],
            ['label' => 'Bahan & Tugas', 'icon' => 'fa-download', 'url' => 'bahan-tugas'],
            ['label' => 'Quiz / Ujian Online', 'icon' => 'fa-pencil-square-o', 'url' => 'quiz'],
            ['label' => 'Penilaian Diri', 'icon' => 'fa-list', 'url' => 'penilaian/diri'],
            ['label' => 'Penilaian Teman', 'icon' => 'fa-list', 'url' => 'penilaian/teman'],
            ['label' => 'Forum Diskusi', 'icon' => 'fa-th-list', 'url' => 'forum'],
            ['label' => 'Laporan Nilai', 'icon' => 'fa-calendar', 'children' => [
                ['label' => 'Nilai UTS', 'url' => 'raport/uts-saya'],
                ['label' => 'Nilai Raport', 'url' => 'raport/saya'],
            ]],
        ];
    }
}
