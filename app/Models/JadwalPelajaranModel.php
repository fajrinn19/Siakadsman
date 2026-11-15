<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalPelajaranModel extends Model
{
    protected $table            = 'rb_jadwal_pelajaran';
    protected $primaryKey       = 'kodejdwl';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_tahun_akademik',
        'kode_kelas',
        'kode_pelajaran',
        'kode_ruangan',
        'nip',
        'paralel',
        'jadwal_serial',
        'jam_mulai',
        'jam_selesai',
        'hari',
        'aktif',
    ];

    /** Builder jadwal lengkap dengan nama mapel, guru, ruangan, dan kelas. */
    public function lengkap(): self
    {
        return $this->select('rb_jadwal_pelajaran.*, m.namamatapelajaran, m.kode_kurikulum, m.id_kelompok_mata_pelajaran, g.nama_guru, g.foto, r.nama_ruangan, k.nama_kelas')
            ->join('rb_mata_pelajaran m', 'rb_jadwal_pelajaran.kode_pelajaran = m.kode_pelajaran')
            ->join('rb_guru g', 'rb_jadwal_pelajaran.nip = g.nip')
            ->join('rb_ruangan r', 'rb_jadwal_pelajaran.kode_ruangan = r.kode_ruangan')
            ->join('rb_kelas k', 'rb_jadwal_pelajaran.kode_kelas = k.kode_kelas');
    }

    /**
     * Daftar jadwal sesuai filter.
     *
     * @param array{kelas?: string|null, tahun?: string|null, nip?: string|null, kurikulum?: int|null} $f
     *
     * @return list<array<string, mixed>>
     */
    public function daftar(array $f): array
    {
        $b = $this->lengkap();
        if (! empty($f['kelas'])) {
            $b->where('rb_jadwal_pelajaran.kode_kelas', $f['kelas']);
        }
        if (! empty($f['tahun'])) {
            $b->where('rb_jadwal_pelajaran.id_tahun_akademik', $f['tahun']);
        }
        if (! empty($f['nip'])) {
            $b->where('rb_jadwal_pelajaran.nip', $f['nip']);
        }
        if (! empty($f['kurikulum'])) {
            $b->where('m.kode_kurikulum', $f['kurikulum']);
        }

        return $b->orderBy('rb_jadwal_pelajaran.hari', 'DESC')->orderBy('rb_jadwal_pelajaran.jam_mulai', 'ASC')->findAll();
    }

    public function detail(int|string $kodejdwl): ?array
    {
        return $this->lengkap()->where('rb_jadwal_pelajaran.kodejdwl', $kodejdwl)->first();
    }

    /**
     * Apakah pengguna boleh membuka jadwal ini?
     * Guru hanya jadwal yang diampunya, siswa hanya jadwal kelasnya; admin & kepala semua.
     *
     * @param array<string, mixed> $jadwal
     * @param array<string, string> $user
     */
    public function bolehAkses(array $jadwal, array $user): bool
    {
        return match ($user['level']) {
            'guru'  => (string) $jadwal['nip'] === $user['id'],
            'siswa' => (string) $jadwal['kode_kelas'] === $user['kode_kelas'],
            default => true,
        };
    }
}
