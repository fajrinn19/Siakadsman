<?php

namespace App\Models;

use CodeIgniter\Model;

class GuruModel extends Model
{
    protected $table            = 'rb_guru';
    protected $primaryKey       = 'nip';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nip',
        'password',
        'nama_guru',
        'id_jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'nik',
        'niy_nigk',
        'nuptk',
        'id_status_kepegawaian',
        'id_jenis_ptk',
        'pengawas_bidang_studi',
        'id_agama',
        'alamat_jalan',
        'rt',
        'rw',
        'nama_dusun',
        'desa_kelurahan',
        'kecamatan',
        'kode_pos',
        'telepon',
        'hp',
        'email',
        'tugas_tambahan',
        'id_status_keaktifan',
        'sk_cpns',
        'tanggal_cpns',
        'sk_pengangkatan',
        'tmt_pengangkatan',
        'lembaga_pengangkatan',
        'id_golongan',
        'keahlian_laboratorium',
        'sumber_gaji',
        'nama_ibu_kandung',
        'id_status_pernikahan',
        'nama_suami_istri',
        'nip_suami_istri',
        'pekerjaan_suami_istri',
        'tmt_pns',
        'lisensi_kepsek',
        'jumlah_sekolah_binaan',
        'diklat_kepengawasan',
        'mampu_handle_kk',
        'keahlian_breile',
        'keahlian_bahasa_isyarat',
        'npwp',
        'kewarganegaraan',
        'foto',
    ];

    /** @return array<string, string> */
    public function opsi(string $kosong = '- Pilih Guru -'): array
    {
        return pilihan($this->orderBy('nama_guru', 'ASC')->findAll(), 'nip', 'nama_guru', $kosong);
    }

    /** Detail guru beserta semua label referensinya. */
    public function detail(string $nip): ?array
    {
        return $this->select('rb_guru.*, jk.jenis_kelamin, sk.status_kepegawaian, p.jenis_ptk, a.nama_agama, ka.nama_status_keaktifan, gl.nama_golongan, sp.status_pernikahan')
            ->join('rb_jenis_kelamin jk', 'rb_guru.id_jenis_kelamin = jk.id_jenis_kelamin', 'left')
            ->join('rb_status_kepegawaian sk', 'rb_guru.id_status_kepegawaian = sk.id_status_kepegawaian', 'left')
            ->join('rb_jenis_ptk p', 'rb_guru.id_jenis_ptk = p.id_jenis_ptk', 'left')
            ->join('rb_agama a', 'rb_guru.id_agama = a.id_agama', 'left')
            ->join('rb_status_keaktifan ka', 'rb_guru.id_status_keaktifan = ka.id_status_keaktifan', 'left')
            ->join('rb_golongan gl', 'rb_guru.id_golongan = gl.id_golongan', 'left')
            ->join('rb_status_pernikahan sp', 'rb_guru.id_status_pernikahan = sp.id_status_pernikahan', 'left')
            ->where('rb_guru.nip', $nip)
            ->first();
    }
}
