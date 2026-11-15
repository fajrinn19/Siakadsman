<?php

namespace App\Models;

use CodeIgniter\Model;

class JournalListModel extends Model
{
    protected $table            = 'rb_journal_list';
    protected $primaryKey       = 'id_journal';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'kodejdwl',
        'hari',
        'tanggal',
        'jam_ke',
        'materi',
        'keterangan',
        'waktu_input',
        'users',
    ];
}
