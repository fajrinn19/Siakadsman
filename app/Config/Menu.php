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
        'ortu'      => 'Orang Tua / Wali',
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
            'ortu'      => $this->ortu(),
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
                ['label' => 'Akun Orang Tua', 'url' => 'akun-ortu'],
                ['label' => 'Impor Siswa (Excel)', 'url' => 'siswa/impor'],
                ['label' => 'Alumni', 'url' => 'alumni'],
            ]],
            ['label' => 'Data Akademik', 'icon' => 'fa-tag', 'children' => [
                ['label' => 'Kelompok Mapel', 'url' => 'kelompok-mapel'],
                ['label' => 'Mata Pelajaran', 'url' => 'mata-pelajaran'],
                ['label' => 'Jadwal Pelajaran', 'url' => 'jadwal-pelajaran'],
                ['label' => 'Kompetensi Dasar', 'url' => 'kompetensi-dasar'],
                ['label' => 'Penilaian Diri', 'url' => 'penilaian-diri'],
                ['label' => 'Rentang Nilai', 'url' => 'predikat'],
                ['label' => 'Penilaian Teman', 'url' => 'penilaian-teman'],
                ['label' => 'Kenaikan Kelas', 'url' => 'kenaikan-kelas'],
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
            ['label' => 'PPDB', 'icon' => 'fa-user-plus', 'url' => 'ppdb/admin'],
            ['label' => 'Informasi', 'icon' => 'fa-bullhorn', 'children' => [
                ['label' => 'Kelola Pengumuman', 'url' => 'pengumuman'],
                ['label' => 'Kelola Kalender', 'url' => 'kalender'],
                ['label' => 'Lihat Kalender', 'url' => 'info/kalender'],
                ['label' => 'Notifikasi WhatsApp', 'url' => 'notifikasi'],
            ]],
            ['label' => 'Sistem', 'icon' => 'fa-cogs', 'children' => [
                ['label' => 'Pemeriksaan Data', 'url' => 'pemeriksaan-data'],
                ['label' => 'Log Aktivitas', 'url' => 'log-aktivitas'],
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
            ['label' => 'Alumni', 'icon' => 'fa-graduation-cap', 'url' => 'alumni'],
            ['label' => 'PPDB', 'icon' => 'fa-user-plus', 'url' => 'ppdb/admin'],
            ['label' => 'Pengumuman', 'icon' => 'fa-bullhorn', 'url' => 'info/pengumuman'],
            ['label' => 'Kalender Akademik', 'icon' => 'fa-calendar-o', 'url' => 'info/kalender'],
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
            ['label' => 'Pengumuman', 'icon' => 'fa-bullhorn', 'url' => 'info/pengumuman'],
            ['label' => 'Kalender Akademik', 'icon' => 'fa-calendar-o', 'url' => 'info/kalender'],
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
            ['label' => 'Pengumuman', 'icon' => 'fa-bullhorn', 'url' => 'info/pengumuman'],
            ['label' => 'Kalender Akademik', 'icon' => 'fa-calendar-o', 'url' => 'info/kalender'],
        ];
    }

    /** @return list<array<string, mixed>> */
    private function ortu(): array
    {
        return [
            ['label' => 'Dashboard', 'icon' => 'fa-dashboard', 'url' => 'ortu'],
            ['label' => 'Profil Anak', 'icon' => 'fa-child', 'url' => 'profil'],
            ['label' => 'Absensi Anak', 'icon' => 'fa-calendar-check-o', 'url' => 'ortu/absensi'],
            ['label' => 'Tugas Anak', 'icon' => 'fa-files-o', 'url' => 'ortu/tugas'],
            ['label' => 'Nilai', 'icon' => 'fa-calendar', 'children' => [
                ['label' => 'Nilai UTS', 'url' => 'raport/uts-saya'],
                ['label' => 'Nilai Raport', 'url' => 'raport/saya'],
            ]],
            ['label' => 'Pengumuman', 'icon' => 'fa-bullhorn', 'url' => 'info/pengumuman'],
            ['label' => 'Kalender Akademik', 'icon' => 'fa-calendar-o', 'url' => 'info/kalender'],
        ];
    }
}
