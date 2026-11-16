<?php

namespace App\Models;

use CodeIgniter\Model;

class PsbSaudaraModel extends Model
{
    protected $table            = 'rb_psb_pendaftaran_saudara';
    protected $primaryKey       = 'id_saudara';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_pendaftaran',
        'nama_saudara',
        'umur_saudara',
        'pendidikan_saudara',
    ];
}
