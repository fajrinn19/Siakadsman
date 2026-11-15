<?php

namespace App\Controllers\Master;

use App\Models\PertanyaanPenilaianModel;

/** Bank pertanyaan penilaian teman (status = 'teman'). */
class PenilaianTeman extends CrudController
{
    protected string $modelClass = PertanyaanPenilaianModel::class;
    protected string $judul      = 'Data Pertanyaan Penilaian Teman';
    protected string $segmen     = 'penilaian-teman';

    protected function daftar(array $filter): array
    {
        return $this->model()->where('status', 'teman')->orderBy('id_pertanyaan_penilaian', 'DESC')->findAll();
    }

    protected function cari(string $id): ?array
    {
        return $this->model()->where('status', 'teman')->find($id);
    }

    protected function kolom(): array
    {
        return ['pertanyaan' => 'Pertanyaan'];
    }

    protected function field(): array
    {
        return [
            ['name' => 'pertanyaan', 'label' => 'Pertanyaan', 'type' => 'textarea', 'rules' => 'required|max_length[255]'],
        ];
    }

    protected function siapkan(array $data, ?array $lama): array
    {
        if ($lama === null) {
            $data['status']      = 'teman';
            $data['waktu_input'] = date('Y-m-d H:i:s');
        }

        return $data;
    }
}
