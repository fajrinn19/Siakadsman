<?php

namespace App\Models;

use CodeIgniter\Model;

class PertanyaanPenilaianJawabModel extends Model
{
    protected $table            = 'rb_pertanyaan_penilaian_jawab';
    protected $primaryKey       = 'id_pertanyaan_penilaian_jawab';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_pertanyaan_penilaian',
        'nisn',
        'nisn_teman',
        'jawaban',
        'status',
        'kode_kelas',
        'waktu_jawab',
    ];
}
