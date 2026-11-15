<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsensiSiswaModel extends Model
{
    protected $table            = 'rb_absensi_siswa';
    protected $primaryKey       = 'id_absensi_siswa';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'kodejdwl',
        'nisn',
        'kode_kehadiran',
        'tanggal',
        'waktu_input',
    ];
}
