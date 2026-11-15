<?php

namespace App\Models;

use CodeIgniter\Model;

class NilaiSikapSemesterModel extends Model
{
    protected $table            = 'rb_nilai_sikap_semester';
    protected $primaryKey       = 'id_nilai_sikap_semester';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_tahun_akademik',
        'nisn',
        'kode_kelas',
        'spiritual_predikat',
        'spiritual_deskripsi',
        'sosial_predikat',
        'sosial_deskripsi',
        'user_akses',
        'waktu_input',
    ];
}
