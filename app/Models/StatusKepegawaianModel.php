<?php

namespace App\Models;

use CodeIgniter\Model;

class StatusKepegawaianModel extends Model
{
    protected $table            = 'rb_status_kepegawaian';
    protected $primaryKey       = 'id_status_kepegawaian';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'status_kepegawaian',
        'keterangan',
    ];
}
