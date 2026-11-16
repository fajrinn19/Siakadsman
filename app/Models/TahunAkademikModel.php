<?php

namespace App\Models;

use CodeIgniter\Model;

class TahunAkademikModel extends Model
{
    protected $table            = 'rb_tahun_akademik';
    protected $primaryKey       = 'id_tahun_akademik';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_tahun_akademik',
        'nama_tahun',
        'keterangan',
        'aktif',
    ];

    /** @return list<array<string, mixed>> */
    public function semua(): array
    {
        return $this->orderBy('id_tahun_akademik', 'DESC')->findAll();
    }

    /** Tahun akademik yang ditandai aktif (jika lebih dari satu, ambil kode terbesar). */
    public function aktif(): ?array
    {
        return $this->where('aktif', 'Ya')->orderBy('id_tahun_akademik', 'DESC')->first();
    }

    /**
     * Tahun akademik bawaan jika pengguna belum memilih: yang aktif, atau yang kodenya diawali tahun berjalan.
     */
    public function bawaan(): ?string
    {
        $row = $this->aktif() ?? $this->like('id_tahun_akademik', date('Y'), 'after')->orderBy('id_tahun_akademik', 'DESC')->first();

        return $row['id_tahun_akademik'] ?? null;
    }
}
