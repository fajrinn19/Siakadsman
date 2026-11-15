<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Riwayat kelas siswa (masuk, naik, pindah, tinggal kelas, atau perubahan data).
 */
class RiwayatKelasModel extends Model
{
    public const JENIS = ['Masuk', 'Naik Kelas', 'Pindah Kelas', 'Tinggal Kelas', 'Perubahan Data'];

    protected $table            = 'rb_riwayat_kelas';
    protected $primaryKey       = 'id_riwayat_kelas';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nisn',
        'kode_kelas_asal',
        'kode_kelas_tujuan',
        'angkatan_asal',
        'angkatan_tujuan',
        'id_tahun_akademik',
        'jenis',
        'keterangan',
        'user_akses',
        'waktu',
    ];

    /**
     * Catat perpindahan kelas. Tidak mencatat apa pun jika kelas dan angkatan tidak berubah,
     * kecuali jenisnya "Tinggal Kelas" (yang memang sengaja tetap di kelas yang sama).
     */
    public function catat(
        string $nisn,
        string $kelasAsal,
        string $kelasTujuan,
        int|string $angkatanAsal,
        int|string $angkatanTujuan,
        string $jenis,
        string $tahun = '',
        string $keterangan = '',
    ): void {
        $berubah = $kelasAsal !== $kelasTujuan || (int) $angkatanAsal !== (int) $angkatanTujuan;
        if (! $berubah && $jenis !== 'Tinggal Kelas') {
            return;
        }

        $this->insert([
            'nisn'              => $nisn,
            'kode_kelas_asal'   => $kelasAsal,
            'kode_kelas_tujuan' => $kelasTujuan,
            'angkatan_asal'     => (int) $angkatanAsal,
            'angkatan_tujuan'   => (int) $angkatanTujuan,
            'id_tahun_akademik' => $tahun,
            'jenis'             => in_array($jenis, self::JENIS, true) ? $jenis : 'Perubahan Data',
            'keterangan'        => $keterangan,
            'user_akses'        => (string) session('id'),
            'waktu'             => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Riwayat seorang siswa (terbaru di atas) beserta nama kelas dan tahun akademik.
     *
     * @return list<array<string, mixed>>
     */
    public function untukSiswa(string $nisn): array
    {
        return $this->select('rb_riwayat_kelas.*, ka.nama_kelas AS nama_kelas_asal, kt.nama_kelas AS nama_kelas_tujuan, t.nama_tahun, u.nama_lengkap AS nama_pencatat')
            ->join('rb_kelas ka', 'rb_riwayat_kelas.kode_kelas_asal = ka.kode_kelas', 'left')
            ->join('rb_kelas kt', 'rb_riwayat_kelas.kode_kelas_tujuan = kt.kode_kelas', 'left')
            ->join('rb_tahun_akademik t', 'rb_riwayat_kelas.id_tahun_akademik = t.id_tahun_akademik', 'left')
            ->join('rb_users u', 'rb_riwayat_kelas.user_akses = u.id_user', 'left')
            ->where('rb_riwayat_kelas.nisn', $nisn)
            ->orderBy('rb_riwayat_kelas.waktu', 'DESC')
            ->orderBy('rb_riwayat_kelas.id_riwayat_kelas', 'DESC')
            ->findAll();
    }

    /**
     * Kelas & tanggal siswa diterima di sekolah, untuk raport.
     * Pakai catatan "Masuk"; untuk siswa lama tanpa catatan itu, pakai kelas asal riwayat paling awal (tanpa tanggal).
     *
     * @return array{kelas: string, tanggal: string}|null
     */
    public function diterima(string $nisn): ?array
    {
        $masuk = $this->where(['nisn' => $nisn, 'jenis' => 'Masuk'])->orderBy('waktu', 'ASC')->first();
        if ($masuk !== null) {
            return ['kelas' => $masuk['kode_kelas_tujuan'], 'tanggal' => substr($masuk['waktu'], 0, 10)];
        }
        $awal = $this->where('nisn', $nisn)->orderBy('waktu', 'ASC')->orderBy('id_riwayat_kelas', 'ASC')->first();

        return $awal !== null && $awal['kode_kelas_asal'] !== '' ? ['kelas' => $awal['kode_kelas_asal'], 'tanggal' => ''] : null;
    }

    /**
     * NISN siswa yang pernah berada di kelas ini tetapi sekarang sudah pindah/naik ke kelas lain.
     *
     * @return list<string>
     */
    public function mantanAnggota(string $kodeKelas): array
    {
        return array_values(array_unique(array_column(
            $this->select('rb_riwayat_kelas.nisn')
                ->join('rb_siswa s', 'rb_riwayat_kelas.nisn = s.nisn')
                ->where('rb_riwayat_kelas.kode_kelas_asal', $kodeKelas)
                ->where('s.kode_kelas !=', $kodeKelas)
                ->findAll(),
            'nisn'
        )));
    }
}
