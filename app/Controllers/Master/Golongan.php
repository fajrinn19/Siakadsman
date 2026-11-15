<?php

namespace App\Controllers\Master;

use App\Models\GolonganModel;

class Golongan extends CrudController
{
    protected string $modelClass = GolonganModel::class;
    protected string $judul      = 'Data Golongan';
    protected string $segmen     = 'golongan';

    protected function kolom(): array
    {
        return [
            'nama_golongan'         => 'Nama Golongan',
            'keterangan' => 'Keterangan',
        ];
    }

    protected function field(): array
    {
        return [
            ['name' => 'nama_golongan', 'label' => 'Nama Golongan', 'rules' => 'required|max_length[150]'],
            ['name' => 'keterangan', 'label' => 'Keterangan', 'type' => 'textarea', 'rows' => 3],
        ];
    }
}
