<?php

namespace App\Controllers;

use App\Libraries\Password;
use App\Models\AgamaModel;
use App\Models\GolonganModel;
use App\Models\GuruModel;
use App\Models\JenisKelaminModel;
use App\Models\JenisPtkModel;
use App\Models\StatusKeaktifanModel;
use App\Models\StatusKepegawaianModel;
use App\Models\StatusPernikahanModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class Guru extends BaseController
{
    private const FOLDER_FOTO = FCPATH . 'uploads/foto_pegawai';

    public function index(): string
    {
        $baris = model(GuruModel::class)
            ->select('rb_guru.*, jk.jenis_kelamin, sk.status_kepegawaian, p.jenis_ptk')
            ->join('rb_jenis_kelamin jk', 'rb_guru.id_jenis_kelamin = jk.id_jenis_kelamin', 'left')
            ->join('rb_status_kepegawaian sk', 'rb_guru.id_status_kepegawaian = sk.id_status_kepegawaian', 'left')
            ->join('rb_jenis_ptk p', 'rb_guru.id_jenis_ptk = p.id_jenis_ptk', 'left')
            ->orderBy('rb_guru.nip', 'DESC')
            ->findAll();

        return view('guru/index', ['judul' => 'Data Guru', 'baris' => $baris]);
    }

    public function detail(string $nip): string
    {
        $g = $this->wajibAda(model(GuruModel::class)->detail($nip), 'Guru tidak ditemukan.');

        return view('guru/detail', ['judul' => 'Detail Data Guru', 'g' => $g, 'bolehEdit' => $this->bolehEdit($nip)]);
    }

    public function tambah(): string
    {
        $this->wajibBolehUbah();

        return view('guru/form', [
            'judul'  => 'Tambah Data Guru',
            'row'    => ['rt' => '00', 'rw' => '00', 'kewarganegaraan' => 'Indonesia'],
            'kolom'  => $this->field(true),
            'action' => site_url('guru/tambah'),
            'baru'   => true,
        ]);
    }

    public function simpan(): RedirectResponse
    {
        $this->wajibBolehUbah();

        if (! $this->validate($this->aturan(null))) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data             = $this->bersihkan($this->inputPost($this->namaField()));
        $data['password'] = Password::hash($data['password']);
        $data['foto']     = $this->unggahFoto() ?? '';

        model(GuruModel::class)->insert($data);

        return $this->kembali(site_url('guru/detail/' . rawurlencode($data['nip'])), 'Data guru berhasil ditambahkan.');
    }

    public function edit(string $nip): string
    {
        $g = $this->guruUntukEdit($nip);

        return view('guru/form', [
            'judul'  => 'Edit Data Guru',
            'row'    => $g,
            'kolom'  => $this->field(false),
            'action' => site_url('guru/edit/' . rawurlencode($nip)),
            'baru'   => false,
        ]);
    }

    public function update(string $nip): RedirectResponse
    {
        $lama = $this->guruUntukEdit($nip);

        if (! $this->validate($this->aturan($lama))) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $kolom = $this->namaField();
        if (level() !== 'superuser') {
            // Guru tidak boleh mengganti NIP-nya sendiri (dipakai sebagai username login).
            $kolom = array_values(array_diff($kolom, ['nip']));
        }
        $data = $this->bersihkan($this->inputPost($kolom));
        if ($data['password'] === '') {
            unset($data['password']);
        } else {
            $data['password'] = Password::hash($data['password']);
        }
        if (($foto = $this->unggahFoto()) !== null) {
            $data['foto'] = $foto;
            $this->hapusFoto($lama['foto']);
        }

        model(GuruModel::class)->update($nip, $data);

        return $this->kembali(site_url('guru/detail/' . rawurlencode($data['nip'] ?? $nip)), 'Data guru berhasil diperbarui.');
    }

    public function hapus(string $nip): RedirectResponse
    {
        $this->wajibBolehUbah();
        $g = $this->wajibAda(model(GuruModel::class)->find($nip));

        if ($this->db->table('rb_jadwal_pelajaran')->where('nip', $nip)->countAllResults() > 0) {
            return $this->gagal(site_url('guru'), 'Guru tidak dapat dihapus karena masih memiliki jadwal mengajar.');
        }

        model(GuruModel::class)->delete($nip);
        $this->hapusFoto($g['foto']);

        return $this->kembali(site_url('guru'), 'Data guru berhasil dihapus.');
    }

    // ------------------------------------------------------------------ Bantuan

    private function bolehEdit(string $nip): bool
    {
        return level() === 'superuser' || (level() === 'guru' && $nip === session('id'));
    }

    private function guruUntukEdit(string $nip): array
    {
        if (! $this->bolehEdit($nip)) {
            throw PageNotFoundException::forPageNotFound('Anda tidak boleh mengubah data guru ini.');
        }

        return $this->wajibAda(model(GuruModel::class)->find($nip), 'Guru tidak ditemukan.');
    }

    /** @return array<string, string> */
    private function aturan(?array $lama): array
    {
        $unik = $lama === null ? '|is_unique[rb_guru.nip]' : '|is_unique[rb_guru.nip,nip,' . $lama['nip'] . ']';

        return [
            'nip'       => (level() === 'superuser' ? 'required|max_length[30]' . $unik : 'permit_empty'),
            'nama_guru' => 'required|max_length[150]',
            'password'  => $lama === null ? 'required|min_length[4]' : 'permit_empty|min_length[4]',
            'email'     => 'permit_empty|valid_email',
            'foto'      => 'permit_empty|is_image[foto]|max_size[foto,2048]',
        ];
    }

    /** Kolom angka & tanggal kosong diubah ke nilai aman untuk kolom NOT NULL. */
    private function bersihkan(array $data): array
    {
        foreach (['kode_pos', 'jumlah_sekolah_binaan', 'id_jenis_kelamin', 'id_agama', 'id_jenis_ptk', 'id_status_kepegawaian',
            'id_status_keaktifan', 'id_status_pernikahan', 'id_golongan'] as $k) {
            if (array_key_exists($k, $data)) {
                $data[$k] = (int) $data[$k];
            }
        }
        foreach (['tanggal_lahir', 'tanggal_cpns', 'tmt_pengangkatan', 'tmt_pns'] as $k) {
            if (array_key_exists($k, $data) && $data[$k] === '') {
                $data[$k] = '0000-00-00';
            }
        }

        return $data;
    }

    /** @return list<string> */
    private function namaField(): array
    {
        return array_merge(...array_map(static fn ($g) => array_column($g, 'name'), array_values($this->field(true))));
    }

    private function unggahFoto(): ?string
    {
        $file = $this->request->getFile('foto');
        if ($file === null || ! $file->isValid() || $file->hasMoved()) {
            return null;
        }
        $nama = date('YmdHis') . '-' . $file->getRandomName();
        $file->move(self::FOLDER_FOTO, $nama);

        return $nama;
    }

    private function hapusFoto(?string $foto): void
    {
        $path = self::FOLDER_FOTO . '/' . basename((string) $foto);
        if (trim((string) $foto) !== '' && is_file($path)) {
            @unlink($path);
        }
    }

    /**
     * Field form dikelompokkan menjadi dua kolom seperti tampilan lama.
     *
     * @return array<string, list<array<string, mixed>>>
     */
    private function field(bool $baru): array
    {
        $opsi = static fn (string $model, string $key, string $label, string $kosong) => pilihan(model($model)->findAll(), $key, $label, $kosong);

        return [
            'Data Pribadi' => [
                ['name' => 'nip', 'label' => 'NIP', 'rules' => 'required', 'readonly' => ! $baru && level() !== 'superuser'],
                ['name' => 'password', 'label' => 'Password', 'type' => 'password', 'rules' => $baru ? 'required' : ''],
                ['name' => 'nama_guru', 'label' => 'Nama Lengkap', 'rules' => 'required'],
                ['name' => 'tempat_lahir', 'label' => 'Tempat Lahir'],
                ['name' => 'tanggal_lahir', 'label' => 'Tanggal Lahir', 'type' => 'date'],
                ['name' => 'id_jenis_kelamin', 'label' => 'Jenis Kelamin', 'type' => 'select', 'options' => $opsi(JenisKelaminModel::class, 'id_jenis_kelamin', 'jenis_kelamin', '- Pilih Jenis Kelamin -')],
                ['name' => 'id_agama', 'label' => 'Agama', 'type' => 'select', 'options' => $opsi(AgamaModel::class, 'id_agama', 'nama_agama', '- Pilih Agama -')],
                ['name' => 'hp', 'label' => 'No HP'],
                ['name' => 'telepon', 'label' => 'No Telpon'],
                ['name' => 'email', 'label' => 'Alamat Email', 'type' => 'email'],
                ['name' => 'alamat_jalan', 'label' => 'Alamat'],
                ['name' => 'rt', 'label' => 'RT'],
                ['name' => 'rw', 'label' => 'RW'],
                ['name' => 'nama_dusun', 'label' => 'Dusun'],
                ['name' => 'desa_kelurahan', 'label' => 'Kelurahan'],
                ['name' => 'kecamatan', 'label' => 'Kecamatan'],
                ['name' => 'kode_pos', 'label' => 'Kode Pos', 'type' => 'number'],
                ['name' => 'nik', 'label' => 'NIK'],
                ['name' => 'npwp', 'label' => 'NPWP'],
                ['name' => 'kewarganegaraan', 'label' => 'Kewarganegaraan'],
                ['name' => 'nama_ibu_kandung', 'label' => 'Nama Ibu Kandung'],
                ['name' => 'id_status_pernikahan', 'label' => 'Status Nikah', 'type' => 'select', 'options' => $opsi(StatusPernikahanModel::class, 'id_status_pernikahan', 'status_pernikahan', '- Pilih Status Pernikahan -')],
                ['name' => 'nama_suami_istri', 'label' => 'Nama Suami/Istri'],
                ['name' => 'nip_suami_istri', 'label' => 'NIP Suami/Istri'],
                ['name' => 'pekerjaan_suami_istri', 'label' => 'Pekerjaan Suami/Istri'],
            ],
            'Data Kepegawaian' => [
                ['name' => 'nuptk', 'label' => 'NUPTK'],
                ['name' => 'niy_nigk', 'label' => 'NIY / NIGK'],
                ['name' => 'id_jenis_ptk', 'label' => 'Jenis PTK', 'type' => 'select', 'options' => $opsi(JenisPtkModel::class, 'id_jenis_ptk', 'jenis_ptk', '- Pilih Jenis PTK -')],
                ['name' => 'id_status_kepegawaian', 'label' => 'Status Pegawai', 'type' => 'select', 'options' => $opsi(StatusKepegawaianModel::class, 'id_status_kepegawaian', 'status_kepegawaian', '- Pilih Status Kepegawaian -')],
                ['name' => 'id_status_keaktifan', 'label' => 'Status Keaktifan', 'type' => 'select', 'options' => $opsi(StatusKeaktifanModel::class, 'id_status_keaktifan', 'nama_status_keaktifan', '- Pilih Status Keaktifan -')],
                ['name' => 'id_golongan', 'label' => 'Golongan', 'type' => 'select', 'options' => $opsi(GolonganModel::class, 'id_golongan', 'nama_golongan', '- Pilih Golongan -')],
                ['name' => 'pengawas_bidang_studi', 'label' => 'Bidang Studi'],
                ['name' => 'tugas_tambahan', 'label' => 'Tugas Tambahan'],
                ['name' => 'sk_cpns', 'label' => 'SK CPNS'],
                ['name' => 'tanggal_cpns', 'label' => 'Tanggal CPNS', 'type' => 'date'],
                ['name' => 'sk_pengangkatan', 'label' => 'SK Pengangkatan'],
                ['name' => 'tmt_pengangkatan', 'label' => 'TMT Pengangkatan', 'type' => 'date'],
                ['name' => 'lembaga_pengangkatan', 'label' => 'Lembaga Pengangkatan'],
                ['name' => 'tmt_pns', 'label' => 'TMT PNS', 'type' => 'date'],
                ['name' => 'sumber_gaji', 'label' => 'Sumber Gaji'],
                ['name' => 'keahlian_laboratorium', 'label' => 'Keahlian Laboratorium'],
                ['name' => 'lisensi_kepsek', 'label' => 'Lisensi Kepsek'],
                ['name' => 'jumlah_sekolah_binaan', 'label' => 'Jml Sekolah Binaan', 'type' => 'number'],
                ['name' => 'diklat_kepengawasan', 'label' => 'Diklat Kepengawasan'],
                ['name' => 'mampu_handle_kk', 'label' => 'Mampu Handle KK'],
                ['name' => 'keahlian_breile', 'label' => 'Keahlian Braille'],
                ['name' => 'keahlian_bahasa_isyarat', 'label' => 'Keahlian Bahasa Isyarat'],
            ],
        ];
    }
}
