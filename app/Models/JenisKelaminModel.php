<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisKelaminModel extends Model
{
    protected $table            = 'rb_jenis_kelamin';
    protected $primaryKey       = 'id_jenis_kelamin';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'jenis_kelamin',
    ];
}
