<?php

namespace App\Models;

use CodeIgniter\Model;

class IdentitasSekolahModel extends Model
{
    protected $table            = 'rb_identitas_sekolah';
    protected $primaryKey       = 'id_identitas_sekolah';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nama_sekolah',
        'npsn',
        'nss',
        'alamat_sekolah',
        'kode_pos',
        'no_telpon',
        'kelurahan',
        'kecamatan',
        'kabupaten_kota',
        'provinsi',
        'website',
        'email',
    ];
}
