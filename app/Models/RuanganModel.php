<?php

namespace App\Models;

use CodeIgniter\Model;

class RuanganModel extends Model
{
    protected $table            = 'rb_ruangan';
    protected $primaryKey       = 'kode_ruangan';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'kode_ruangan',
        'kode_gedung',
        'nama_ruangan',
        'kapasitas_belajar',
        'kapasitas_ujian',
        'keterangan',
        'aktif',
    ];
}
