<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriElearningModel extends Model
{
    protected $table            = 'rb_kategori_elearning';
    protected $primaryKey       = 'id_kategori_elearning';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nama_kategori_elearning',
    ];
}
