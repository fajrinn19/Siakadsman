<?php

namespace App\Models;

use CodeIgniter\Model;

class PengumumanModel extends Model
{
    protected $table            = 'rb_pengumuman';
    protected $primaryKey       = 'id_pengumuman';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['judul', 'isi', 'untuk', 'tanggal_mulai', 'tanggal_selesai', 'user_akses', 'waktu'];

    /**
     * Pengumuman yang sedang berlaku untuk level pengguna tertentu.
     *
     * @return list<array<string, mixed>>
     */
    public function berlaku(string $level, int $batas = 5): array
    {
        $sasaran = match ($level) {
            'guru'  => 'guru',
            'siswa' => 'siswa',
            'ortu'  => 'ortu',
            default => null,
        };
        $b = $this->where('tanggal_mulai <=', date('Y-m-d'))->where('tanggal_selesai >=', date('Y-m-d'));
        if ($sasaran !== null) {
            $b->whereIn('untuk', ['semua', $sasaran]);
        }

        return $b->orderBy('tanggal_mulai', 'DESC')->findAll($batas);
    }
}
