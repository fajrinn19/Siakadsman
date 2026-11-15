<?php

namespace App\Models;

use CodeIgniter\Model;

class KurikulumModel extends Model
{
    protected $table            = 'rb_kurikulum';
    protected $primaryKey       = 'kode_kurikulum';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nama_kurikulum',
        'status_kurikulum',
    ];

    /** Kurikulum yang sedang dipakai (status_kurikulum = 'Ya', yang pertama). */
    public function aktif(): ?array
    {
        return $this->where('status_kurikulum', 'Ya')->orderBy('kode_kurikulum', 'ASC')->first();
    }
}
