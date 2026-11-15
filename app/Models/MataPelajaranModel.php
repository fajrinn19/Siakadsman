<?php

namespace App\Models;

use CodeIgniter\Model;

class MataPelajaranModel extends Model
{
    protected $table            = 'rb_mata_pelajaran';
    protected $primaryKey       = 'kode_pelajaran';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'kode_pelajaran',
        'id_kelompok_mata_pelajaran',
        'kode_jurusan',
        'nip',
        'kode_kurikulum',
        'namamatapelajaran',
        'namamatapelajaran_en',
        'tingkat',
        'kompetensi_umum',
        'kompetensi_khusus',
        'jumlah_jam',
        'sesi',
        'urutan',
        'aktif',
    ];
}
