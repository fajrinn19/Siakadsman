<?php

namespace App\Models;

use CodeIgniter\Model;

class KalenderModel extends Model
{
    protected $table            = 'rb_kalender';
    protected $primaryKey       = 'id_kalender';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['judul', 'jenis', 'tanggal_mulai', 'tanggal_selesai', 'keterangan'];

    /** @return list<array<string, mixed>> Agenda yang belum lewat, terdekat dulu. */
    public function mendatang(int $batas = 5): array
    {
        return $this->where('tanggal_selesai >=', date('Y-m-d'))->orderBy('tanggal_mulai', 'ASC')->findAll($batas);
    }
}
