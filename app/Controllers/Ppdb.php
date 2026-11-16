<?php

namespace App\Controllers;

use App\Libraries\Password;
use App\Models\AgamaModel;
use App\Models\JenisKelaminModel;
use App\Models\KelasModel;
use App\Models\PsbPendaftaranModel;
use App\Models\RiwayatKelasModel;
use App\Models\SiswaModel;
use App\Models\TahunAkademikModel;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * PPDB (pendaftaran peserta didik baru): formulir publik tanpa login,
 * cek status dengan kode pendaftaran, dan verifikasi oleh admin.
 *
 * Status disimpan di rb_psb_aktivasi.proses: 0 = menunggu, 1 = diterima, 2 = ditolak.
 */
class Ppdb extends BaseController
{
    public const STATUS = [0 => ['Menunggu verifikasi', 'chip-tunggu'], 1 => ['Diterima', 'chip-aktif'], 2 => ['Tidak diterima', 'chip-redup']];

    // ------------------------------------------------------------------ Publik

    public function formulir(): string
    {
        return view('ppdb/formulir', [
            'sekolah' => config('Sekolah'),
            'field'   => $this->field(),
            'buka'    => config('Sekolah')->ppdbBuka,
        ]);
    }

    public function daftar(): RedirectResponse
    {
        if (! config('Sekolah')->ppdbBuka) {
            return redirect()->to(site_url('ppdb'))->with('error', 'Pendaftaran sedang ditutup.');
        }
        $aturan = [];
        foreach ($this->field() as $grup) {
            foreach ($grup as $f) {
                if (! empty($f['rules'])) {
                    $aturan[$f['name']] = ['label' => $f['label'], 'rules' => $f['rules']];
                }
            }
        }
        if (! $this->validate($aturan)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $kode = 'SMA-' . date('YmdHis') . strtoupper(substr(bin2hex(random_bytes(2)), 0, 3));
        $data = $this->inputPost(array_merge(...array_map(static fn ($g) => array_column($g, 'name'), array_values($this->field()))));
        $data['id_jenis_kelamin'] = (int) $data['id_jenis_kelamin'];
        $data['id_agama']         = (int) $data['id_agama'];

        $this->db->transStart();
        model(PsbPendaftaranModel::class)->insert($data + ['kode_pendaftaran' => $kode, 'status' => 'sma', 'waktu_daftar' => date('Y-m-d H:i:s')]);
        $this->db->table('rb_psb_aktivasi')->insert([
            'kode_pendaftaran' => $kode, 'nama_lengkap' => $data['nama'], 'status' => 'sma', 'proses' => 0, 'waktu_input' => date('Y-m-d H:i:s'),
        ]);
        $this->db->transComplete();

        return redirect()->to(site_url('ppdb/status') . '?kode=' . rawurlencode($kode))
            ->with('sukses', "Pendaftaran berhasil. Simpan kode pendaftaran Anda: {$kode}");
    }

    public function status(): string
    {
        $kode = trim((string) $this->request->getGet('kode'));
        $data = $kode === '' ? null : $this->db->table('rb_psb_pendaftaran p')
            ->select('p.kode_pendaftaran, p.nama, p.sekolah_asal, p.waktu_daftar, a.proses')
            ->join('rb_psb_aktivasi a', 'a.kode_pendaftaran = p.kode_pendaftaran', 'left')
            ->where('p.kode_pendaftaran', $kode)->get()->getRowArray();

        return view('ppdb/status', ['sekolah' => config('Sekolah'), 'kode' => $kode, 'data' => $data]);
    }

    // ------------------------------------------------------------------ Admin

    public function admin(): string
    {
        $status = $this->request->getGet('status');
        $b      = $this->db->table('rb_psb_pendaftaran p')
            ->select('p.id_pendaftaran, p.kode_pendaftaran, p.nama, p.sekolah_asal, p.no_telpon, p.waktu_daftar, COALESCE(a.proses, 0) AS proses', false)
            ->join('rb_psb_aktivasi a', 'a.kode_pendaftaran = p.kode_pendaftaran', 'left');
        if ($status !== null && $status !== '') {
            $b->where('COALESCE(a.proses, 0)', (int) $status, false);
        }

        return view('ppdb/admin', [
            'judul'  => 'Pendaftar PPDB',
            'baris'  => $b->orderBy('p.id_pendaftaran', 'DESC')->get()->getResultArray(),
            'status' => (string) $status,
            'buka'   => config('Sekolah')->ppdbBuka,
        ]);
    }

    public function detail(int $id): string
    {
        $p = $this->wajibAda($this->db->table('rb_psb_pendaftaran p')
            ->select('p.*, COALESCE(a.proses, 0) AS proses, jk.jenis_kelamin, ag.nama_agama', false)
            ->join('rb_psb_aktivasi a', 'a.kode_pendaftaran = p.kode_pendaftaran', 'left')
            ->join('rb_jenis_kelamin jk', 'p.id_jenis_kelamin = jk.id_jenis_kelamin', 'left')
            ->join('rb_agama ag', 'p.id_agama = ag.id_agama', 'left')
            ->where('p.id_pendaftaran', $id)->get()->getRowArray());

        return view('ppdb/detail', [
            'judul'     => 'Detail Pendaftar',
            'p'         => $p,
            'field'     => $this->field(),
            'kelasOpsi' => model(KelasModel::class)->opsi(),
        ]);
    }

    /** Terima pendaftar: buat data siswa (password awal = NISN, wajib diganti) + riwayat "Masuk". */
    public function terima(int $id): RedirectResponse
    {
        $this->wajibBolehUbah();
        $p     = $this->wajibAda(model(PsbPendaftaranModel::class)->find($id));
        $nisn  = preg_replace('/\s+/', '', (string) $this->request->getPost('nisn'));
        $kelas = (string) $this->request->getPost('kode_kelas');
        $url   = site_url("ppdb/admin/{$id}");

        if ($nisn === '' || $kelas === '') {
            return $this->gagal($url, 'NISN dan kelas wajib diisi untuk menerima pendaftar.');
        }
        if (model(SiswaModel::class)->cariNisn($nisn) !== null) {
            return $this->gagal($url, "NISN {$nisn} sudah terdaftar sebagai siswa.");
        }

        $this->db->transStart();
        model(SiswaModel::class)->insert([
            'nisn'             => $nisn,
            'nipd'             => (string) $p['no_induk'],
            'password'         => Password::hash($nisn),
            'nama'             => $p['nama'],
            'id_jenis_kelamin' => (int) $p['id_jenis_kelamin'],
            'tempat_lahir'     => $p['tempat_lahir'],
            'tanggal_lahir'    => $p['tanggal_lahir'],
            'id_agama'         => (int) $p['id_agama'],
            'alamat'           => $p['alamat_siswa'],
            'telepon'          => $p['no_telpon'],
            'nama_ayah'        => $p['nama_ayah'],
            'pekerjaan_ayah'   => $p['pekerjaan_ayah'],
            'no_telpon_ayah'   => $p['telpon_rumah_ayah'],
            'nama_ibu'         => $p['nama_ibu'],
            'pekerjaan_ibu'    => $p['pekerjaan_ibu'],
            'nama_wali'        => $p['nama_wali'],
            'kode_kelas'       => $kelas,
            'angkatan'         => (int) date('Y'),
            'status_awal'      => 'Siswa Baru',
            'status_siswa'     => 'Aktif',
            'tingkat'          => '',
            'id_sesi'          => 0,
            'foto'             => '',
        ]);
        model(RiwayatKelasModel::class)->catat($nisn, '', $kelas, 0, (int) date('Y'), 'Masuk',
            (string) model(TahunAkademikModel::class)->bawaan(), 'Diterima melalui PPDB (' . $p['kode_pendaftaran'] . ')');
        $this->setProses($p['kode_pendaftaran'], $p['nama'], 1);
        $this->db->transComplete();

        return $this->kembali($url, "{$p['nama']} diterima dan ditambahkan sebagai siswa kelas {$kelas}. Login: NISN {$nisn} (password awal = NISN).");
    }

    public function tolak(int $id): RedirectResponse
    {
        $this->wajibBolehUbah();
        $p = $this->wajibAda(model(PsbPendaftaranModel::class)->find($id));
        $this->setProses($p['kode_pendaftaran'], $p['nama'], 2);

        return $this->kembali(site_url("ppdb/admin/{$id}"), 'Pendaftar ditandai tidak diterima.');
    }

    private function setProses(string $kode, string $nama, int $proses): void
    {
        $t = $this->db->table('rb_psb_aktivasi');
        if ($t->where('kode_pendaftaran', $kode)->countAllResults() > 0) {
            $this->db->table('rb_psb_aktivasi')->where('kode_pendaftaran', $kode)->update(['proses' => $proses]);
        } else {
            $this->db->table('rb_psb_aktivasi')->insert(['kode_pendaftaran' => $kode, 'nama_lengkap' => $nama, 'status' => 'sma', 'proses' => $proses, 'waktu_input' => date('Y-m-d H:i:s')]);
        }
    }

    /** @return array<string, list<array<string, mixed>>> */
    private function field(): array
    {
        $jk    = pilihan(model(JenisKelaminModel::class)->findAll(), 'id_jenis_kelamin', 'jenis_kelamin', '- Pilih -');
        $agama = pilihan(model(AgamaModel::class)->findAll(), 'id_agama', 'nama_agama', '- Pilih -');

        return [
            'Data Calon Siswa' => [
                ['name' => 'nama', 'label' => 'Nama Lengkap', 'rules' => 'required|max_length[255]'],
                ['name' => 'nama_panggilan', 'label' => 'Nama Panggilan'],
                ['name' => 'no_induk', 'label' => 'NISN (jika ada)', 'rules' => 'permit_empty|max_length[50]'],
                ['name' => 'id_jenis_kelamin', 'label' => 'Jenis Kelamin', 'type' => 'select', 'options' => $jk, 'rules' => 'required|is_natural_no_zero'],
                ['name' => 'tempat_lahir', 'label' => 'Tempat Lahir', 'rules' => 'required'],
                ['name' => 'tanggal_lahir', 'label' => 'Tanggal Lahir', 'type' => 'date', 'rules' => 'required|valid_date[Y-m-d]'],
                ['name' => 'id_agama', 'label' => 'Agama', 'type' => 'select', 'options' => $agama, 'rules' => 'required|is_natural_no_zero'],
                ['name' => 'anak_ke', 'label' => 'Anak ke'],
                ['name' => 'jumlah_saudara', 'label' => 'Jumlah Saudara'],
                ['name' => 'alamat_siswa', 'label' => 'Alamat', 'type' => 'textarea', 'rows' => 2, 'rules' => 'required'],
                ['name' => 'no_telpon', 'label' => 'No HP / WhatsApp', 'rules' => 'required|max_length[15]'],
                ['name' => 'sekolah_asal', 'label' => 'Sekolah Asal (SMP/MTs)', 'rules' => 'required'],
                ['name' => 'alamat_sekolah_asal', 'label' => 'Alamat Sekolah Asal', 'type' => 'textarea', 'rows' => 2],
            ],
            'Data Orang Tua / Wali' => [
                ['name' => 'nama_ayah', 'label' => 'Nama Ayah', 'rules' => 'required'],
                ['name' => 'pekerjaan_ayah', 'label' => 'Pekerjaan Ayah'],
                ['name' => 'telpon_rumah_ayah', 'label' => 'No HP Ayah', 'rules' => 'permit_empty|max_length[15]'],
                ['name' => 'nama_ibu', 'label' => 'Nama Ibu', 'rules' => 'required'],
                ['name' => 'pekerjaan_ibu', 'label' => 'Pekerjaan Ibu'],
                ['name' => 'telpon_rumah_ibu', 'label' => 'No HP Ibu', 'rules' => 'permit_empty|max_length[15]'],
                ['name' => 'nama_wali', 'label' => 'Nama Wali (jika ada)'],
                ['name' => 'no_telpon_wali', 'label' => 'No HP Wali', 'rules' => 'permit_empty|max_length[15]'],
            ],
        ];
    }
}
