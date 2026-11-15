<?php

namespace App\Models;

use CodeIgniter\Model;

class NilaiExtrakulikulerModel extends Model
{
    protected $table            = 'rb_nilai_extrakulikuler';
    protected $primaryKey       = 'id_nilai_extrakulikuler';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_tahun_akademik',
        'nisn',
        'kode_kelas',
        'kegiatan',
        'nilai',
        'deskripsi',
        'user_akses',
        'waktu_input',
    ];
}
