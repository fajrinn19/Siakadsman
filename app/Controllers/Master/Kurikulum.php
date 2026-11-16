<?php

namespace App\Controllers\Master;

use App\Models\KurikulumModel;

class Kurikulum extends CrudController
{
    protected string $modelClass = KurikulumModel::class;
    protected string $judul      = 'Data Kurikulum';
    protected string $segmen     = 'kurikulum';

    protected function kolom(): array
    {
        return [
            'nama_kurikulum'   => 'Nama Kurikulum',
            'status_kurikulum' => 'Status Aktif',
        ];
    }

    protected function field(): array
    {
        return [
            ['name' => 'nama_kurikulum', 'label' => 'Nama Kurikulum', 'rules' => 'required|max_length[255]'],
            ['name' => 'status_kurikulum', 'label' => 'Aktif', 'type' => 'radio', 'options' => ['Ya' => 'Ya', 'Tidak' => 'Tidak'], 'default' => 'Tidak'],
        ];
    }

    /** Hanya satu kurikulum yang boleh aktif. */
    protected function setelahSimpan(array $data, string $id): void
    {
        if (($data['status_kurikulum'] ?? '') === 'Ya') {
            $this->model()->where('kode_kurikulum !=', $id)->set('status_kurikulum', 'Tidak')->update();
        }
    }
}
