<?php

namespace App\Controllers;

use App\Models\ElearningJawabModel;
use App\Models\JadwalPelajaranModel;
use App\Models\KalenderModel;
use App\Models\PengumumanModel;
use App\Models\SiswaModel;
use App\Models\TahunAkademikModel;

/** Halaman untuk orang tua: memantau absensi, tugas, dan nilai anak. */
class PortalOrtu extends BaseController
{
    public function dashboard(): string
    {
        $anak   = $this->anak();
        $tahun  = (string) model(TahunAkademikModel::class)->bawaan();
        $jadwal = model(JadwalPelajaranModel::class)->daftar(['kelas' => $anak['kode_kelas'], 'tahun' => $tahun]);

        return view('ortu/dashboard', [
            'judul'      => 'Portal Orang Tua',
            'subjudul'   => 'Memantau ' . $anak['nama'],
            'anak'       => $anak,
            'absen'      => $this->rekapAbsen($anak['nisn'], array_column($jadwal, 'kodejdwl')),
            'tugas'      => $this->daftarTugas($anak, array_column($jadwal, 'kodejdwl')),
            'pengumuman' => model(PengumumanModel::class)->berlaku('ortu', 3),
            'agenda'     => model(KalenderModel::class)->mendatang(4),
        ]);
    }

    public function absensi(): string
    {
        $anak  = $this->anak();
        $tahun = (string) ($this->request->getGet('tahun') ?: model(TahunAkademikModel::class)->bawaan());

        $rows = $this->db->table('rb_absensi_siswa a')
            ->select('a.tanggal, a.kode_kehadiran, k.nama_kehadiran, m.namamatapelajaran, j.jam_mulai')
            ->join('rb_jadwal_pelajaran j', 'a.kodejdwl = j.kodejdwl')
            ->join('rb_mata_pelajaran m', 'j.kode_pelajaran = m.kode_pelajaran', 'left')
            ->join('rb_kehadiran k', 'a.kode_kehadiran = k.kode_kehadiran', 'left')
            ->where(['a.nisn' => $anak['nisn'], 'j.id_tahun_akademik' => $tahun])
            ->orderBy('a.tanggal', 'DESC')->get()->getResultArray();

        $jumlah = ['H' => 0, 'S' => 0, 'I' => 0, 'A' => 0];
        foreach ($rows as $r) {
            if (isset($jumlah[$r['kode_kehadiran']])) {
                $jumlah[$r['kode_kehadiran']]++;
            }
        }

        return view('ortu/absensi', [
            'judul'     => 'Absensi ' . $anak['nama'],
            'baris'     => $rows,
            'jumlah'    => $jumlah,
            'tahun'     => $tahun,
            'tahunOpsi' => pilihan(model(TahunAkademikModel::class)->semua(), 'id_tahun_akademik', 'nama_tahun', '- Pilih Tahun Akademik -'),
        ]);
    }

    public function tugas(): string
    {
        $anak   = $this->anak();
        $jadwal = model(JadwalPelajaranModel::class)->daftar(['kelas' => $anak['kode_kelas'], 'tahun' => (string) model(TahunAkademikModel::class)->bawaan()]);

        return view('ortu/tugas', ['judul' => 'Tugas ' . $anak['nama'], 'tugas' => $this->daftarTugas($anak, array_column($jadwal, 'kodejdwl'), 100)]);
    }

    private function anak(): array
    {
        return $this->wajibAda(model(SiswaModel::class)->detail((string) session('nisn_anak')), 'Data anak tidak ditemukan.');
    }

    /** @param list<int|string> $jadwal */
    private function rekapAbsen(string $nisn, array $jadwal): array
    {
        $hasil = ['H' => 0, 'S' => 0, 'I' => 0, 'A' => 0];
        if ($jadwal === []) {
            return $hasil;
        }
        foreach ($this->db->table('rb_absensi_siswa')->select('kode_kehadiran, COUNT(*) AS total')->where('nisn', $nisn)
            ->whereIn('kodejdwl', $jadwal)->groupBy('kode_kehadiran')->get()->getResultArray() as $r) {
            $hasil[$r['kode_kehadiran']] = (int) $r['total'];
        }

        return $hasil;
    }

    /**
     * Tugas (bukan bahan) untuk kelas anak beserta status pengirimannya.
     *
     * @param list<int|string> $jadwal
     */
    private function daftarTugas(array $anak, array $jadwal, int $batas = 6): array
    {
        if ($jadwal === []) {
            return [];
        }
        $tugas = $this->db->table('rb_elearning e')
            ->select('e.*, m.namamatapelajaran')
            ->join('rb_jadwal_pelajaran j', 'e.kodejdwl = j.kodejdwl')
            ->join('rb_mata_pelajaran m', 'j.kode_pelajaran = m.kode_pelajaran', 'left')
            ->where('e.id_kategori_elearning', 2)->whereIn('e.kodejdwl', $jadwal)
            ->orderBy('e.tanggal_selesai', 'DESC')->limit($batas)->get()->getResultArray();
        $kirim = $tugas === [] ? [] : array_column(model(ElearningJawabModel::class)->where('nisn', $anak['nisn'])
            ->whereIn('id_elearning', array_column($tugas, 'id_elearning'))->findAll(), 'waktu', 'id_elearning');

        foreach ($tugas as &$t) {
            $t['dikirim'] = $kirim[$t['id_elearning']] ?? null;
            $t['habis']   = tgl_valid($t['tanggal_selesai']) && strtotime($t['tanggal_selesai']) < time();
        }

        return $tugas;
    }
}
