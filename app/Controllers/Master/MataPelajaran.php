<?php

namespace App\Controllers\Master;

use App\Models\GuruModel;
use App\Models\JurusanModel;
use App\Models\KelompokMataPelajaranModel;
use App\Models\KurikulumModel;
use App\Models\MataPelajaranModel;

class MataPelajaran extends CrudController
{
    protected string $modelClass = MataPelajaranModel::class;
    protected string $judul      = 'Data Mata Pelajaran';
    protected string $segmen     = 'mata-pelajaran';
    protected bool $adaDetail    = true;

    /** Hanya mapel kurikulum aktif yang ditampilkan, urut sesuai kolom urutan. */
    protected function daftar(array $filter): array
    {
        return $this->model()->select('rb_mata_pelajaran.*, k.nama_kelompok_mata_pelajaran, g.nama_guru, j.nama_jurusan')
            ->join('rb_kelompok_mata_pelajaran k', 'rb_mata_pelajaran.id_kelompok_mata_pelajaran = k.id_kelompok_mata_pelajaran', 'left')
            ->join('rb_guru g', 'rb_mata_pelajaran.nip = g.nip', 'left')
            ->join('rb_jurusan j', 'rb_mata_pelajaran.kode_jurusan = j.kode_jurusan', 'left')
            ->where('rb_mata_pelajaran.kode_kurikulum', $this->kurikulumAktif())
            ->orderBy('rb_mata_pelajaran.urutan', 'ASC')
            ->findAll();
    }

    protected function kolom(): array
    {
        return [
            'kode_pelajaran'    => 'Kode Mapel',
            'namamatapelajaran' => 'Nama Mapel',
            'nama_jurusan'      => 'Jurusan',
            'tingkat'           => 'Tingkat',
            'nama_guru'         => 'Guru Pengampu',
            'urutan'            => 'Urutan',
        ];
    }

    protected function field(): array
    {
        return [
            ['name' => 'kode_kurikulum', 'label' => 'Kurikulum', 'type' => 'select', 'rules' => 'required', 'default' => $this->kurikulumAktif(),
                'options' => static fn () => pilihan(model(KurikulumModel::class)->findAll(), 'kode_kurikulum', 'nama_kurikulum', '- Pilih Kurikulum -')],
            ['name' => 'kode_pelajaran', 'label' => 'Kode Pelajaran', 'rules' => 'required|max_length[20]'],
            ['name' => 'namamatapelajaran', 'label' => 'Nama Mapel', 'rules' => 'required|max_length[150]'],
            ['name' => 'namamatapelajaran_en', 'label' => 'Nama Mapel (English)'],
            ['name' => 'kode_jurusan', 'label' => 'Jurusan', 'type' => 'select',
                'options' => static fn () => pilihan(model(JurusanModel::class)->findAll(), 'kode_jurusan', 'nama_jurusan', '- Pilih Jurusan -')],
            ['name' => 'nip', 'label' => 'Guru Pengampu', 'type' => 'select', 'options' => static fn () => model(GuruModel::class)->opsi('- Pilih Guru Pengampu -')],
            ['name' => 'tingkat', 'label' => 'Tingkat'],
            ['name' => 'kompetensi_umum', 'label' => 'Kompetensi Umum'],
            ['name' => 'kompetensi_khusus', 'label' => 'Kompetensi Khusus'],
            ['name' => 'jumlah_jam', 'label' => 'Jumlah Jam'],
            ['name' => 'urutan', 'label' => 'Urutan', 'type' => 'number', 'rules' => 'permit_empty|is_natural'],
            ['name' => 'sesi', 'label' => 'Sesi'],
            ['name' => 'id_kelompok_mata_pelajaran', 'label' => 'Kelompok', 'type' => 'select', 'rules' => 'required',
                'options' => static fn () => pilihan(model(KelompokMataPelajaranModel::class)->findAll(), 'id_kelompok_mata_pelajaran', 'nama_kelompok_mata_pelajaran', '- Pilih Kelompok -')],
            ['name' => 'aktif', 'label' => 'Aktif', 'type' => 'radio', 'options' => ['Ya' => 'Ya', 'Tidak' => 'Tidak']],
        ];
    }

    protected function siapkan(array $data, ?array $lama): array
    {
        $data['urutan'] = (int) $data['urutan'];

        return $data;
    }
}
