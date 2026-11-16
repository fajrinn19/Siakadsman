<?php

namespace App\Controllers;

use App\Models\JadwalPelajaranModel;
use App\Models\KalenderModel;
use App\Models\PengumumanModel;
use App\Models\KompetensiDasarModel;
use App\Models\TahunAkademikModel;
use CodeIgniter\HTTP\RedirectResponse;

class Dashboard extends BaseController
{
    public function index(): string|RedirectResponse
    {
        return match (level()) {
            'guru', 'siswa' => $this->penggunaKelas(),
            'ortu'          => redirect()->to(site_url('ortu')),
            default         => $this->admin(),
        };
    }

    /** Arahkan "Profil Saya" ke halaman yang sesuai level. */
    public function profil(): RedirectResponse
    {
        $id = rawurlencode((string) session('id'));

        return redirect()->to(match (level()) {
            'guru'  => site_url("guru/detail/{$id}"),
            'siswa' => site_url("siswa/detail/{$id}"),
            'ortu'  => site_url('siswa/detail/' . rawurlencode((string) session('nisn_anak'))),
            default => site_url("admin/edit/{$id}"),
        });
    }

    /** Siswa melihat kompetensi dasar untuk satu jadwal di kelasnya. */
    public function kompetensi(int $kodejdwl): string
    {
        $jadwal = $this->jadwal($kodejdwl);

        return view('dashboard/kompetensi', [
            'judul'  => 'Kompetensi Dasar',
            'jadwal' => $jadwal,
            'baris'  => model(KompetensiDasarModel::class)->where('kodejdwl', $kodejdwl)->orderBy('id_kompetensi_dasar', 'DESC')->findAll(),
        ]);
    }

    // ------------------------------------------------------------------ Admin & kepala sekolah

    private function admin(): string
    {
        $db     = $this->db;
        $hitung = static fn (string $tabel, array $where = []): int => $db->table($tabel)->where($where)->countAllResults();
        $tahunGrafik = (int) ($this->request->getGet('tahun_grafik') ?: date('Y'));

        return view('dashboard/admin', [
            'judul'    => 'Dashboard',
            'subjudul' => 'Ringkasan akademik',
            'ringkas'  => [
                'siswa_aktif' => $hitung('rb_siswa', ['status_siswa' => 'Aktif']),
                'siswa'       => $hitung('rb_siswa'),
                'guru'        => $hitung('rb_guru'),
                'kelas'       => $hitung('rb_kelas', ['aktif' => 'Ya']),
                'mapel'       => $hitung('rb_mata_pelajaran', ['kode_kurikulum' => $this->kurikulumAktif()]),
            ],
            'mini'        => $this->kartuMini(),
            'kehadiran'   => $this->kehadiran(),
            'porsi'       => $this->porsiKunjungan(),
            'tahunGrafik' => $tahunGrafik,
            'grafik'      => $this->kunjunganBulanan($tahunGrafik),
            'jadwal'      => $this->jadwalHariIni(['kurikulum' => $this->kurikulumAktif()]),
            'pengumuman'  => model(PengumumanModel::class)->berlaku(level(), 3),
            'agenda'      => model(KalenderModel::class)->mendatang(4),
        ]);
    }

    /** Tiga kartu kecil: bahan & tugas, quiz, forum — beserta tren 6 bulan terakhir. */
    private function kartuMini(): array
    {
        $bulan = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan[] = date('Y-m', strtotime("first day of -{$i} month"));
        }
        $tren = function (string $tabel, string $kolom) use ($bulan): array {
            $rows = array_column($this->db->table($tabel)
                ->select("DATE_FORMAT({$kolom}, '%Y-%m') AS bln, COUNT(*) AS total", false)
                ->where("{$kolom} >=", $bulan[0] . '-01')
                ->groupBy('bln')->get()->getResultArray(), 'total', 'bln');

            return array_map(static fn ($b) => (int) ($rows[$b] ?? 0), $bulan);
        };
        $terakhir = fn (string $tabel, string $kolom): string => (string) ($this->db->table($tabel)->selectMax($kolom, 'm')->get()->getRow()->m ?? '');

        return [
            ['label' => 'Bahan & Tugas', 'judul' => 'E-Learning', 'ikon' => 'fa-files-o', 'url' => 'bahan-tugas', 'warna' => '#f5b71a',
                'total' => $this->db->table('rb_elearning')->countAllResults(), 'tren' => $tren('rb_elearning', 'tanggal_tugas'), 'terakhir' => $terakhir('rb_elearning', 'tanggal_tugas')],
            ['label' => 'Quiz & Ujian', 'judul' => 'Ujian Online', 'ikon' => 'fa-pencil-square-o', 'url' => 'quiz', 'warna' => '#17a589',
                'total' => $this->db->table('rb_quiz_ujian')->countAllResults(), 'tren' => $tren('rb_quiz_ujian', 'batas_waktu'), 'terakhir' => $terakhir('rb_quiz_ujian', 'batas_waktu')],
            ['label' => 'Topik Forum', 'judul' => 'Forum Diskusi', 'ikon' => 'fa-comments-o', 'url' => 'forum', 'warna' => '#4c9a5b',
                'total' => $this->db->table('rb_forum_topic')->countAllResults(), 'tren' => $tren('rb_forum_topic', 'waktu'), 'terakhir' => $terakhir('rb_forum_topic', 'waktu')],
        ];
    }

    /** Jumlah absensi siswa per status kehadiran. */
    private function kehadiran(): array
    {
        $rows = array_column($this->db->table('rb_absensi_siswa')->select('kode_kehadiran, COUNT(*) AS total')
            ->groupBy('kode_kehadiran')->get()->getResultArray(), 'total', 'kode_kehadiran');

        return [
            ['kode' => 'H', 'label' => 'Hadir', 'warna' => '#0f6b5c', 'total' => (int) ($rows['H'] ?? 0)],
            ['kode' => 'S', 'label' => 'Sakit', 'warna' => '#f5b71a', 'total' => (int) ($rows['S'] ?? 0)],
            ['kode' => 'I', 'label' => 'Izin', 'warna' => '#7fc8b8', 'total' => (int) ($rows['I'] ?? 0)],
            ['kode' => 'A', 'label' => 'Alpa', 'warna' => '#f28c70', 'total' => (int) ($rows['A'] ?? 0)],
        ];
    }

    /** Persentase kunjungan per jenis pengguna, 30 hari terakhir. */
    private function porsiKunjungan(): array
    {
        $rows  = array_column($this->db->table('rb_users_aktivitas')->select('status, COUNT(*) AS total')
            ->where('tanggal >=', date('Y-m-d', strtotime('-30 days')))->groupBy('status')->get()->getResultArray(), 'total', 'status');
        $total = max(1, array_sum($rows));

        return [
            ['label' => 'Siswa', 'warna' => '#17a589', 'persen' => (int) round(($rows['siswa'] ?? 0) / $total * 100), 'jumlah' => (int) ($rows['siswa'] ?? 0)],
            ['label' => 'Guru', 'warna' => '#f5b71a', 'persen' => (int) round(($rows['guru'] ?? 0) / $total * 100), 'jumlah' => (int) ($rows['guru'] ?? 0)],
            ['label' => 'Admin', 'warna' => '#4c9a5b', 'persen' => (int) round(($rows['superuser'] ?? 0) / $total * 100), 'jumlah' => (int) ($rows['superuser'] ?? 0)],
        ];
    }

    /** Kunjungan per bulan dalam setahun, per jenis pengguna. */
    private function kunjunganBulanan(int $tahun): array
    {
        $seri = ['siswa' => array_fill(0, 12, 0), 'guru' => array_fill(0, 12, 0), 'superuser' => array_fill(0, 12, 0)];
        $rows = $this->db->table('rb_users_aktivitas')->select('MONTH(tanggal) AS bln, status, COUNT(*) AS total', false)
            ->where('YEAR(tanggal)', $tahun)->groupBy('bln, status')->get()->getResultArray();
        foreach ($rows as $r) {
            if (isset($seri[$r['status']])) {
                $seri[$r['status']][(int) $r['bln'] - 1] = (int) $r['total'];
            }
        }

        return $seri;
    }

    /** Jadwal pelajaran hari ini pada tahun akademik berjalan. */
    private function jadwalHariIni(array $filter): array
    {
        $tahun = model(TahunAkademikModel::class)->bawaan();
        if ($tahun === null) {
            return [];
        }
        $jam = date('H:i:s');

        return array_map(static fn ($j) => $j + [
            'status' => $jam < $j['jam_mulai'] ? 'akan' : ($jam <= $j['jam_selesai'] ? 'berlangsung' : 'selesai'),
        ], array_values(array_filter(
            model(JadwalPelajaranModel::class)->daftar($filter + ['tahun' => $tahun]),
            static fn ($j) => strcasecmp($j['hari'], hari_ini()) === 0
        )));
    }

    // ------------------------------------------------------------------ Guru & siswa

    private function penggunaKelas(): string
    {
        $guru   = level() === 'guru';
        $tahun  = (string) ($this->request->getGet('tahun') ?: model(TahunAkademikModel::class)->bawaan());
        $filter = $guru ? ['nip' => session('id')] : ['kelas' => session('kode_kelas')];
        $semua  = $tahun !== '' ? model(JadwalPelajaranModel::class)->daftar($filter + ['tahun' => $tahun]) : [];
        $kode   = array_column($semua, 'kodejdwl') ?: [0];
        $hitung = fn (string $tabel, array $where = []) => $this->db->table($tabel)->whereIn('kodejdwl', $kode)->where($where)->countAllResults();

        $statistik = $guru
            ? [
                'Siswa diajar' => $this->db->table('rb_siswa')->whereIn('kode_kelas', array_unique(array_column($semua, 'kode_kelas')) ?: [''])->countAllResults(),
                'Kelas'        => count(array_unique(array_column($semua, 'kode_kelas'))),
                'Topik forum'  => $hitung('rb_forum_topic'),
            ]
            : [
                'Tugas belum dikirim' => $this->tugasBelumDikirim($kode),
                'Quiz berlangsung'    => $this->db->table('rb_quiz_ujian')->whereIn('kodejdwl', $kode)->where('batas_waktu >', date('Y-m-d H:i:s'))->countAllResults(),
                'Topik forum'         => $hitung('rb_forum_topic'),
            ];

        return view('dashboard/pengguna', [
            'judul'     => $guru ? 'Dashboard Guru' : 'Dashboard Siswa',
            'subjudul'  => 'Selamat datang, ' . profil_pengguna()['nama'],
            'guru'      => $guru,
            'tahun'     => $tahun,
            'tahunOpsi' => pilihan(model(TahunAkademikModel::class)->semua(), 'id_tahun_akademik', 'nama_tahun', '- Pilih Tahun Akademik -'),
            'semua'     => $semua,
            'hariIni'   => $this->jadwalHariIni($filter),
            'statistik' => $statistik,
            'pengumuman' => model(PengumumanModel::class)->berlaku(level(), 3),
            'agenda'    => model(KalenderModel::class)->mendatang(4),
            'mini'      => [
                ['label' => 'Bahan & Tugas', 'ikon' => 'fa-files-o', 'url' => 'bahan-tugas', 'total' => $hitung('rb_elearning')],
                ['label' => 'Quiz & Ujian', 'ikon' => 'fa-pencil-square-o', 'url' => 'quiz', 'total' => $hitung('rb_quiz_ujian')],
                ['label' => 'Kompetensi Dasar', 'ikon' => 'fa-tags', 'url' => $guru ? 'kompetensi-dasar' : null, 'total' => $hitung('rb_kompetensi_dasar')],
            ],
        ]);
    }

    /** @param list<int|string> $kode */
    private function tugasBelumDikirim(array $kode): int
    {
        return $this->db->table('rb_elearning e')
            ->where('e.id_kategori_elearning', 2)
            ->whereIn('e.kodejdwl', $kode)
            ->groupStart()->where('e.tanggal_selesai >', date('Y-m-d H:i:s'))->orWhere('e.tanggal_selesai', '0000-00-00 00:00:00')->groupEnd()
            ->where('NOT EXISTS (SELECT 1 FROM rb_elearning_jawab j WHERE j.id_elearning = e.id_elearning AND j.nisn = ' . $this->db->escape((string) session('id')) . ')', null, false)
            ->countAllResults();
    }
}
