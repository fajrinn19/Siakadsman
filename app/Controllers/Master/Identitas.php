<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Models\IdentitasSekolahModel;
use CodeIgniter\HTTP\RedirectResponse;

/** Identitas sekolah: satu baris data yang hanya bisa diubah. */
class Identitas extends BaseController
{
    private const FIELD = [
        'nama_sekolah'   => 'Nama Sekolah',
        'npsn'           => 'NPSN',
        'nss'            => 'NSS',
        'alamat_sekolah' => 'Alamat Sekolah',
        'kode_pos'       => 'Kode Pos',
        'no_telpon'      => 'No Telpon',
        'kelurahan'      => 'Kelurahan',
        'kecamatan'      => 'Kecamatan',
        'kabupaten_kota' => 'Kabupaten / Kota',
        'provinsi'       => 'Provinsi',
        'website'        => 'Website',
        'email'          => 'Email',
    ];

    public function index(): string
    {
        $row   = model(IdentitasSekolahModel::class)->orderBy('id_identitas_sekolah', 'DESC')->first() ?? [];
        $field = [];
        foreach (self::FIELD as $nama => $label) {
            $field[] = ['name' => $nama, 'label' => $label, 'type' => boleh_ubah() ? 'text' : 'static'];
        }

        return view('crud/form', [
            'judul'  => 'Identitas Sekolah',
            'field'  => $field,
            'row'    => $row,
            'action' => site_url('identitas'),
            'batal'  => site_url('/'),
            'baru'   => false,
        ]);
    }

    public function update(): RedirectResponse
    {
        $this->wajibBolehUbah();

        $model = model(IdentitasSekolahModel::class);
        $row   = $model->orderBy('id_identitas_sekolah', 'DESC')->first();
        $data  = $this->inputPost(array_keys(self::FIELD));
        $data['kode_pos'] = (int) $data['kode_pos'];

        $row === null ? $model->insert($data) : $model->update($row['id_identitas_sekolah'], $data);

        return $this->kembali(site_url('identitas'), 'Identitas sekolah berhasil diperbarui.');
    }
}
