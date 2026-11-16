<?php

namespace App\Models;

use CodeIgniter\Model;

class SmsOutboxModel extends Model
{
    protected $table            = 'rb_sms_outbox';
    protected $primaryKey       = 'id_outbox';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nohp', 'pesan', 'waktu'];
}
