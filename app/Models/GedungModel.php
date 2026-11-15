<?php

namespace App\Models;

use CodeIgniter\Model;

class GedungModel extends Model
{
    protected $table            = 'rb_gedung';
    protected $primaryKey       = 'kode_gedung';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'kode_gedung',
        'nama_gedung',
        'jumlah_lantai',
        'panjang',
        'tinggi',
        'lebar',
        'keterangan',
        'aktif',
    ];
}
