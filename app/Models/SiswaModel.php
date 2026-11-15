<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table            = 'rb_siswa';
    protected $primaryKey       = 'id_siswa';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nipd',
        'password',
        'nama',
        'id_jenis_kelamin',
        'nisn',
        'tempat_lahir',
        'tanggal_lahir',
        'nik',
        'id_agama',
        'kebutuhan_khusus',
        'alamat',
        'rt',
        'rw',
        'dusun',
        'kelurahan',
        'kecamatan',
        'kode_pos',
        'jenis_tinggal',
        'alat_transportasi',
        'telepon',
        'hp',
        'email',
        'skhun',
        'penerima_kps',
        'no_kps',
        'foto',
        'nama_ayah',
        'tahun_lahir_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'penghasilan_ayah',
        'kebutuhan_khusus_ayah',
        'no_telpon_ayah',
        'nama_ibu',
        'tahun_lahir_ibu',
        'pendidikan_ibu',
        'pekerjaan_ibu',
        'penghasilan_ibu',
        'kebutuhan_khusus_ibu',
        'no_telpon_ibu',
        'nama_wali',
        'tahun_lahir_wali',
        'pendidikan_wali',
        'pekerjaan_wali',
        'penghasilan_wali',
        'angkatan',
        'status_awal',
        'status_siswa',
        'tingkat',
        'kode_kelas',
        'kode_jurusan',
        'id_sesi',
    ];

    /** Builder siswa lengkap dengan kelas, jenis kelamin, jurusan, dan agama. */
    public function lengkap(): self
    {
        return $this->select('rb_siswa.*, k.nama_kelas, jk.jenis_kelamin, j.nama_jurusan, a.nama_agama')
            ->join('rb_kelas k', 'rb_siswa.kode_kelas = k.kode_kelas', 'left')
            ->join('rb_jenis_kelamin jk', 'rb_siswa.id_jenis_kelamin = jk.id_jenis_kelamin', 'left')
            ->join('rb_jurusan j', 'k.kode_jurusan = j.kode_jurusan', 'left')
            ->join('rb_agama a', 'rb_siswa.id_agama = a.id_agama', 'left');
    }

    public function cariNisn(string $nisn): ?array
    {
        return $this->where('nisn', $nisn)->first();
    }

    public function detail(string $nisn): ?array
    {
        return $this->lengkap()->where('rb_siswa.nisn', $nisn)->first();
    }

    /** @return list<array<string, mixed>> */
    public function perKelas(string $kodeKelas): array
    {
        return $this->lengkap()->where('rb_siswa.kode_kelas', $kodeKelas)->orderBy('rb_siswa.id_siswa', 'ASC')->findAll();
    }
}
