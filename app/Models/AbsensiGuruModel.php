<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsensiGuruModel extends Model
{
    protected $table            = 'rb_absensi_guru';
    protected $primaryKey       = 'id_absensi_guru';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'kodejdwl',
        'nip',
        'kode_kehadiran',
        'tanggal',
        'waktu_input',
    ];
}
