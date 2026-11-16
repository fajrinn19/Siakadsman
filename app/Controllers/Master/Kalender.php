<?php

namespace App\Controllers\Master;

use App\Models\KalenderModel;

class Kalender extends CrudController
{
    public const JENIS = ['Kegiatan' => 'Kegiatan', 'Ujian' => 'Ujian', 'Libur' => 'Libur', 'Rapat' => 'Rapat', 'Pembagian Raport' => 'Pembagian Raport'];

    protected string $modelClass = KalenderModel::class;
    protected string $judul      = 'Kalender Akademik';
    protected string $segmen     = 'kalender';

    protected function daftar(array $filter): array
    {
        return $this->model()->orderBy('tanggal_mulai', 'DESC')->findAll();
    }

    protected function kolom(): array
    {
        return [
            'tanggal_mulai' => ['label' => 'Tanggal', 'format' => static fn ($r) => tgl_indo($r['tanggal_mulai']) . ($r['tanggal_selesai'] !== $r['tanggal_mulai'] ? ' s/d ' . tgl_indo($r['tanggal_selesai']) : '')],
            'judul'         => 'Agenda',
            'jenis'         => 'Jenis',
            'keterangan'    => 'Keterangan',
        ];
    }

    protected function field(): array
    {
        return [
            ['name' => 'judul', 'label' => 'Agenda', 'rules' => 'required|max_length[200]'],
            ['name' => 'jenis', 'label' => 'Jenis', 'type' => 'select', 'options' => self::JENIS],
            ['name' => 'tanggal_mulai', 'label' => 'Tanggal Mulai', 'type' => 'date', 'rules' => 'required|valid_date[Y-m-d]', 'default' => date('Y-m-d')],
            ['name' => 'tanggal_selesai', 'label' => 'Tanggal Selesai', 'type' => 'date', 'rules' => 'required|valid_date[Y-m-d]', 'default' => date('Y-m-d')],
            ['name' => 'keterangan', 'label' => 'Keterangan', 'type' => 'textarea', 'rows' => 3],
        ];
    }

    protected function validasiTambahan(array $data, ?array $lama): ?string
    {
        return $data['tanggal_selesai'] < $data['tanggal_mulai'] ? 'Tanggal selesai tidak boleh sebelum tanggal mulai.' : null;
    }
}
