<?php

namespace App\Models;

use CodeIgniter\Model;

class StatusPernikahanModel extends Model
{
    protected $table            = 'rb_status_pernikahan';
    protected $primaryKey       = 'id_status_pernikahan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'status_pernikahan',
        'keterangan',
    ];
}
