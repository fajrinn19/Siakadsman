<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

/**
 * Pemeriksaan kesehatan data: menemukan data yatim & tidak konsisten, dan membersihkan data yatim.
 */
class PemeriksaanData extends BaseController
{
    /** Tabel yang menunjuk ke rb_jadwal_pelajaran lewat kolom kodejdwl. */
    private const TABEL_JADWAL = [
        'rb_elearning'         => 'Bahan & tugas',
        'rb_quiz_ujian'        => 'Quiz / ujian',
        'rb_forum_topic'       => 'Topik forum',
        'rb_journal_list'      => 'Journal KBM',
        'rb_kompetensi_dasar'  => 'Kompetensi dasar',
        'rb_absensi_siswa'     => 'Absensi siswa',
        'rb_absensi_guru'      => 'Absensi guru',
        'rb_nilai_pengetahuan' => 'Nilai pengetahuan',
        'rb_nilai_keterampilan' => 'Nilai keterampilan',
        'rb_nilai_sikap'       => 'Nilai sikap',
        'rb_nilai_uts'         => 'Nilai UTS',
    ];

    public function index(): string
    {
        $db    = $this->db;
        $hasil = [];

        $aktif = $db->table('rb_tahun_akademik')->where('aktif', 'Ya')->countAllResults();
        $hasil[] = ['judul' => 'Tahun akademik aktif', 'jumlah' => $aktif > 1 ? $aktif : 0,
            'pesan' => $aktif > 1 ? "Ada {$aktif} tahun akademik berstatus aktif. Sebaiknya hanya satu; simpan ulang yang benar di menu Tahun Akademik dan yang lain otomatis nonaktif." : 'Hanya satu yang aktif.',
            'tautan' => site_url('tahun-akademik')];

        $kur = $db->table('rb_kurikulum')->where('status_kurikulum', 'Ya')->countAllResults();
        $hasil[] = ['judul' => 'Kurikulum aktif', 'jumlah' => $kur > 1 ? $kur : 0,
            'pesan' => $kur > 1 ? "Ada {$kur} kurikulum aktif; aplikasi memakai yang kodenya terkecil. Simpan ulang kurikulum yang benar." : 'Hanya satu yang aktif.',
            'tautan' => site_url('kurikulum')];

        $hasil[] = ['judul' => 'Ruangan berkode kosong', 'jumlah' => $db->table('rb_ruangan')->where('kode_ruangan', '')->countAllResults(),
            'pesan' => 'Ruangan tanpa kode tidak bisa diedit dari aplikasi.', 'bersihkan' => 'ruangan-kosong'];

        $hasil[] = ['judul' => 'Siswa dengan kelas tidak terdaftar',
            'jumlah' => (int) $db->query('SELECT COUNT(*) n FROM rb_siswa s LEFT JOIN rb_kelas k ON s.kode_kelas = k.kode_kelas WHERE k.kode_kelas IS NULL')->getRow()->n,
            'pesan' => 'Perbaiki kelasnya lewat Data Siswa atau Impor Excel (centang "perbarui").', 'tautan' => site_url('siswa')];

        $hasil[] = ['judul' => 'Jadwal dengan guru / mapel / kelas / ruangan yang tidak ada',
            'jumlah' => (int) $db->query('SELECT COUNT(*) n FROM rb_jadwal_pelajaran j
                LEFT JOIN rb_guru g ON j.nip = g.nip LEFT JOIN rb_mata_pelajaran m ON j.kode_pelajaran = m.kode_pelajaran
                LEFT JOIN rb_kelas k ON j.kode_kelas = k.kode_kelas LEFT JOIN rb_ruangan r ON j.kode_ruangan = r.kode_ruangan
                WHERE g.nip IS NULL OR m.kode_pelajaran IS NULL OR k.kode_kelas IS NULL OR r.kode_ruangan IS NULL')->getRow()->n,
            'pesan' => 'Jadwal seperti ini tidak muncul di daftar jadwal (karena join gagal). Perbaiki referensinya di database atau hapus jadwalnya.'];

        $dup = (int) $db->query('SELECT COUNT(*) n FROM (SELECT nisn FROM rb_siswa GROUP BY nisn HAVING COUNT(*) > 1) d')->getRow()->n;
        $hasil[] = ['judul' => 'NISN ganda', 'jumlah' => $dup, 'pesan' => 'Satu NISN dipakai lebih dari satu siswa; login dan nilai bisa tertukar.'];

        $lemah = (int) $db->query("SELECT (SELECT COUNT(*) FROM rb_siswa WHERE password = nisn) + (SELECT COUNT(*) FROM rb_guru WHERE password = nip) n")->getRow()->n;
        $hasil[] = ['judul' => 'Password lemah (sama dengan NISN/NIP, belum pernah login)', 'jumlah' => $lemah,
            'pesan' => 'Akun ini akan dipaksa ganti password saat login pertama.', 'info' => true];

        foreach (self::TABEL_JADWAL as $tabel => $label) {
            $n = (int) $db->query("SELECT COUNT(*) n FROM {$tabel} t LEFT JOIN rb_jadwal_pelajaran j ON t.kodejdwl = j.kodejdwl WHERE j.kodejdwl IS NULL")->getRow()->n;
            $hasil[] = ['judul' => "{$label} tanpa jadwal (yatim)", 'jumlah' => $n, 'pesan' => 'Menunjuk ke jadwal pelajaran yang sudah dihapus; tidak tampil di mana pun.', 'bersihkan' => $tabel];
        }

        return view('pemeriksaan/index', ['judul' => 'Pemeriksaan Data', 'hasil' => $hasil]);
    }

    public function bersihkan(string $jenis): RedirectResponse
    {
        if (level() !== 'superuser') {
            return $this->gagal(site_url('pemeriksaan-data'), 'Hanya administrator.');
        }

        if ($jenis === 'ruangan-kosong') {
            $this->db->table('rb_ruangan')->where('kode_ruangan', '')->delete();
            $n = $this->db->affectedRows();
        } elseif (isset(self::TABEL_JADWAL[$jenis])) {
            $this->db->query("DELETE t FROM {$jenis} t LEFT JOIN rb_jadwal_pelajaran j ON t.kodejdwl = j.kodejdwl WHERE j.kodejdwl IS NULL");
            $n = $this->db->affectedRows();
        } else {
            return $this->gagal(site_url('pemeriksaan-data'), 'Jenis pembersihan tidak dikenal.');
        }

        return $this->kembali(site_url('pemeriksaan-data'), "{$n} baris data dihapus.");
    }
}
