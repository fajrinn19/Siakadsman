<?php

namespace App\Models;

use CodeIgniter\Model;

class ElearningModel extends Model
{
    protected $table            = 'rb_elearning';
    protected $primaryKey       = 'id_elearning';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_kategori_elearning',
        'kodejdwl',
        'nama_file',
        'file_upload',
        'tanggal_tugas',
        'tanggal_selesai',
        'keterangan',
    ];
}
