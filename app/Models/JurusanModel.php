<?php

namespace App\Models;

use CodeIgniter\Model;

class JurusanModel extends Model
{
    protected $table            = 'rb_jurusan';
    protected $primaryKey       = 'kode_jurusan';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'kode_jurusan',
        'nama_jurusan',
        'nama_jurusan_en',
        'bidang_keahlian',
        'kompetensi_umum',
        'kompetensi_khusus',
        'pejabat',
        'jabatan',
        'keterangan',
        'aktif',
    ];
}
