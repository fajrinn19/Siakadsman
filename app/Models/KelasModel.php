<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $table            = 'rb_kelas';
    protected $primaryKey       = 'kode_kelas';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'kode_kelas',
        'nip',
        'kode_jurusan',
        'kode_ruangan',
        'nama_kelas',
        'aktif',
    ];

    /** @return list<array<string, mixed>> */
    public function semua(): array
    {
        return $this->orderBy('kode_kelas', 'ASC')->findAll();
    }

    /** @return array<string, string> */
    public function opsi(?string $kosong = '- Pilih Kelas -'): array
    {
        return pilihan($this->semua(), 'kode_kelas', static fn ($k) => $k['kode_kelas'] . ' - ' . $k['nama_kelas'], $kosong);
    }

    /** Detail kelas beserta wali kelas, jurusan, ruangan, dan gedung. */
    public function lengkap(): self
    {
        return $this->select('rb_kelas.*, g.nama_guru, j.nama_jurusan, r.nama_ruangan, gd.nama_gedung')
            ->join('rb_guru g', 'rb_kelas.nip = g.nip', 'left')
            ->join('rb_jurusan j', 'rb_kelas.kode_jurusan = j.kode_jurusan', 'left')
            ->join('rb_ruangan r', 'rb_kelas.kode_ruangan = r.kode_ruangan', 'left')
            ->join('rb_gedung gd', 'r.kode_gedung = gd.kode_gedung', 'left');
    }
}
