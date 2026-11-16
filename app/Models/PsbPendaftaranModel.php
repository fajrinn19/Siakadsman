<?php

namespace App\Models;

use CodeIgniter\Model;

class PsbPendaftaranModel extends Model
{
    protected $table            = 'rb_psb_pendaftaran';
    protected $primaryKey       = 'id_pendaftaran';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'kode_pendaftaran',
        'nama',
        'nama_panggilan',
        'no_induk',
        'id_jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'id_agama',
        'anak_ke',
        'jumlah_saudara',
        'status_dalam_keluarga',
        'alamat_siswa',
        'no_telpon',
        'berat_badan',
        'tinggi_badan',
        'golongan_darah',
        'penyakit_pernah_diderita',
        'diterima_dikelas',
        'diterima_tanggal',
        'sekolah_asal',
        'alamat_sekolah_asal',
        'nama_ayah',
        'tempat_lahir_ayah',
        'tanggal_lahir_ayah',
        'agama_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'alamat_rumah_ayah',
        'telpon_rumah_ayah',
        'alamat_kantor_ayah',
        'telpon_kantor_ayah',
        'nama_ibu',
        'tempat_lahir_ibu',
        'tanggal_lahir_ibu',
        'agama_ibu',
        'pendidikan_ibu',
        'pekerjaan_ibu',
        'alamat_rumah_ibu',
        'telpon_rumah_ibu',
        'alamat_kantor_ibu',
        'telpon_kantor_ibu',
        'nama_wali',
        'alamat_wali',
        'no_telpon_wali',
        'status',
        'waktu_daftar',
    ];
}
