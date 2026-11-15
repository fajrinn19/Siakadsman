<?php

namespace App\Controllers\Master;

use App\Models\StatusKepegawaianModel;

class StatusKepegawaian extends CrudController
{
    protected string $modelClass = StatusKepegawaianModel::class;
    protected string $judul      = 'Data Status Kepegawaian';
    protected string $segmen     = 'status-kepegawaian';

    protected function kolom(): array
    {
        return [
            'status_kepegawaian'         => 'Status Kepegawaian',
            'keterangan' => 'Keterangan',
        ];
    }

    protected function field(): array
    {
        return [
            ['name' => 'status_kepegawaian', 'label' => 'Status Kepegawaian', 'rules' => 'required|max_length[255]'],
            ['name' => 'keterangan', 'label' => 'Keterangan', 'type' => 'textarea', 'rows' => 3],
        ];
    }
}
