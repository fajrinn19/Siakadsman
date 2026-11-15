<?php

namespace App\Models;

use CodeIgniter\Model;

class SmsModel extends Model
{
    protected $table            = 'rb_sms';
    protected $primaryKey       = 'id_sms';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nohp',
        'pesan',
    ];
}
