<?php

namespace App\Models;

use CodeIgniter\Model;

class NilaiPrestasiModel extends Model
{
    protected $table            = 'rb_nilai_prestasi';
    protected $primaryKey       = 'id_nilai_prestasi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_tahun_akademik',
        'nisn',
        'kode_kelas',
        'jenis_kegiatan',
        'keterangan',
        'user_akses',
        'waktu_input',
    ];
}
