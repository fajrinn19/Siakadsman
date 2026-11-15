<?php

namespace App\Controllers\Master;

use App\Models\JenisPtkModel;

class JenisPtk extends CrudController
{
    protected string $modelClass = JenisPtkModel::class;
    protected string $judul      = 'Data Jenis PTK';
    protected string $segmen     = 'jenis-ptk';

    protected function kolom(): array
    {
        return [
            'jenis_ptk'         => 'Jenis PTK',
            'keterangan' => 'Keterangan',
        ];
    }

    protected function field(): array
    {
        return [
            ['name' => 'jenis_ptk', 'label' => 'Jenis PTK', 'rules' => 'required|max_length[100]'],
            ['name' => 'keterangan', 'label' => 'Keterangan', 'type' => 'textarea', 'rows' => 3],
        ];
    }
}
