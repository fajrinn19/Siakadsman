<?php

namespace App\Controllers;

use App\Libraries\Password;
use App\Models\AgamaModel;
use App\Models\JenisKelaminModel;
use App\Models\JurusanModel;
use App\Models\KelasModel;
use App\Models\PertanyaanPenilaianJawabModel;
use App\Models\PertanyaanPenilaianModel;
use App\Models\RiwayatKelasModel;
use App\Models\TahunAkademikModel;
use App\Models\SiswaModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class Siswa extends BaseController
{
    private const FOLDER_FOTO = FCPATH . 'uploads/foto_siswa';

    /** Daftar siswa dengan filter angkatan / kelas, plus pindah kelas massal. */
    public function index(): string
    {
        $angkatan = (string) $this->request->getGet('angkatan');
        $kelas    = (string) $this->request->getGet('kelas');
        $cari     = trim((string) $this->request->getGet('q'));
        $baris    = [];

        if ($angkatan !== '' || $kelas !== '' || $cari !== '') {
            $b = model(SiswaModel::class)->lengkap();
            if ($cari !== '') {
                $b->groupStart()->like('rb_siswa.nama', $cari)->orLike('rb_siswa.nisn', $cari)->orLike('rb_siswa.nipd', $cari)->groupEnd();
            }
            if ($kelas !== '') {
                $b->where('rb_siswa.kode_kelas', $kelas);
            }
            if ($angkatan !== '') {
                $b->where('rb_siswa.angkatan', $angkatan);
            }
            $baris = $b->orderBy('rb_siswa.id_siswa', 'ASC')->findAll();
        }

        return view('siswa/index', [
            'judul'     => 'Data Siswa',
            'angkatan'  => $angkatan,
            'kelas'     => $kelas,
            'cari'      => $cari,
            'tahunOpsi' => pilihan(model(TahunAkademikModel::class)->semua(), 'id_tahun_akademik', 'nama_tahun', '- Tahun Akademik -'),
            'tahunBawaan' => (string) model(TahunAkademikModel::class)->bawaan(),
            'kelasOpsi' => model(KelasModel::class)->opsi('- Filter Kelas -'),
            'baris'     => $baris,
        ]);
    }

    public function tambah(): string
    {
        $this->wajibBolehUbah();

        return view('siswa/form', [
            'judul'     => 'Tambah Data Siswa',
            'row'       => ['rt' => '00', 'rw' => '00', 'status_siswa' => 'Aktif'],
            'fieldData' => $this->fieldData(true, false),
            'fieldOrtu' => $this->fieldOrtu(),
            'action'    => site_url('siswa/tambah'),
            'baru'      => true,
        ]);
    }

    public function simpan(): RedirectResponse
    {
        $this->wajibBolehUbah();

        $kolom = array_merge(array_column($this->fieldData(true, false), 'name'), array_column($this->fieldOrtu(), 'name'));
        if (! $this->validate($this->aturan(null))) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data             = $this->bersihkan($this->inputPost($kolom));
        $data['password'] = Password::hash($data['password']);
        $data['tingkat']  = '';
        $data['id_sesi']  = 0;
        $data['foto']     = $this->unggahFoto() ?? '';

        model(SiswaModel::class)->insert($data);
        model(RiwayatKelasModel::class)->catat($data['nisn'], '', (string) $data['kode_kelas'], 0, $data['angkatan'], 'Masuk', (string) model(TahunAkademikModel::class)->bawaan(), 'Data siswa baru');

        return $this->kembali(site_url('siswa/detail/' . rawurlencode($data['nisn'])), 'Data siswa berhasil ditambahkan.');
    }

    public function detail(string $nisn): string
    {
        if (level() === 'siswa') {
            $nisn = (string) session('id');
        }
        $s = $this->wajibAda(model(SiswaModel::class)->detail($nisn), 'Siswa tidak ditemukan.');

        return view('siswa/detail', [
            'judul'     => 'Detail Data Siswa',
            's'         => $s,
            'bolehEdit' => $this->bolehEdit($s),
            'riwayat'   => model(RiwayatKelasModel::class)->untukSiswa($s['nisn']),
        ]);
    }

    public function edit(string $nisn): string
    {
        $s = $this->siswaUntukEdit($nisn);

        return view('siswa/form', [
            'judul'     => 'Edit Data Siswa',
            'row'       => $s,
            'fieldData' => $this->fieldData(false, level() === 'siswa'),
            'fieldOrtu' => $this->fieldOrtu(),
            'action'    => site_url('siswa/edit/' . rawurlencode($s['nisn'])),
            'actionOrtu' => site_url('siswa/edit/' . rawurlencode($s['nisn']) . '/ortu'),
            'baru'      => false,
            'peringatanSiswa' => level() === 'siswa',
        ]);
    }

    public function update(string $nisn): RedirectResponse
    {
        $s = $this->siswaUntukEdit($nisn);

        $field = array_filter($this->fieldData(false, level() === 'siswa'), static fn ($f) => empty($f['readonly']));
        $aturan = array_intersect_key($this->aturan($s), array_flip([...array_column($field, 'name'), 'foto']));
        if (! $this->validate($aturan)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->bersihkan($this->inputPost(array_column($field, 'name')));
        if (($data['password'] ?? '') === '') {
            unset($data['password']);
        } else {
            $data['password'] = Password::hash($data['password']);
        }
        if (($foto = $this->unggahFoto()) !== null) {
            $data['foto'] = $foto;
            $this->hapusFoto($s['foto']);
        }

        model(SiswaModel::class)->update($s['id_siswa'], $data);
        $nisnBaru = $data['nisn'] ?? $s['nisn'];
        $riwayat  = model(RiwayatKelasModel::class);
        if ($nisnBaru !== $s['nisn']) {
            $riwayat->where('nisn', $s['nisn'])->set('nisn', $nisnBaru)->update();
        }
        if (array_key_exists('kode_kelas', $data)) {
            $riwayat->catat($nisnBaru, (string) $s['kode_kelas'], (string) $data['kode_kelas'], $s['angkatan'], $data['angkatan'] ?? $s['angkatan'],
                'Perubahan Data', (string) model(TahunAkademikModel::class)->bawaan(), 'Diubah lewat form edit siswa');
        }

        return $this->kembali(site_url('siswa/edit/' . rawurlencode($nisnBaru)), 'Data siswa berhasil diperbarui.');
    }

    public function updateOrtu(string $nisn): RedirectResponse
    {
        $s    = $this->siswaUntukEdit($nisn);
        $data = $this->bersihkan($this->inputPost(array_column($this->fieldOrtu(), 'name')));

        model(SiswaModel::class)->update($s['id_siswa'], $data);

        return $this->kembali(site_url('siswa/edit/' . rawurlencode($s['nisn'])) . '#ortu', 'Data orang tua / wali berhasil diperbarui.');
    }

    public function hapus(string $nisn): RedirectResponse
    {
        $this->wajibBolehUbah();
        $s = $this->wajibAda(model(SiswaModel::class)->cariNisn($nisn));

        model(SiswaModel::class)->delete($s['id_siswa']);
        model(RiwayatKelasModel::class)->where('nisn', $s['nisn'])->delete();
        $this->hapusFoto($s['foto']);

        return redirect()->back()->with('sukses', 'Data siswa berhasil dihapus.');
    }

    /** Pindahkan siswa terpilih ke kelas dan/atau angkatan lain. */
    public function pindahKelas(): RedirectResponse
    {
        $this->wajibBolehUbah();

        $nisn     = array_values(array_filter((array) $this->request->getPost('pilih')));
        $kelas    = trim((string) $this->request->getPost('kelas_pindah'));
        $angkatan = trim((string) $this->request->getPost('angkatan_pindah'));
        $jenis    = (string) $this->request->getPost('jenis_pindah');
        $tahun    = (string) $this->request->getPost('tahun_pindah');
        $ket      = trim((string) $this->request->getPost('keterangan_pindah'));
        $set      = array_filter(['kode_kelas' => $kelas, 'angkatan' => $angkatan], static fn ($v) => $v !== '');

        if ($nisn === [] || $set === []) {
            return redirect()->back()->with('error', 'Pilih siswa dan kelas/angkatan tujuan terlebih dahulu.');
        }
        if (! in_array($jenis, RiwayatKelasModel::JENIS, true)) {
            $jenis = 'Pindah Kelas';
        }

        $siswaModel = model(SiswaModel::class);
        $riwayat    = model(RiwayatKelasModel::class);

        $this->db->transStart();
        foreach ($siswaModel->whereIn('nisn', $nisn)->findAll() as $s) {
            $riwayat->catat($s['nisn'], (string) $s['kode_kelas'], $set['kode_kelas'] ?? (string) $s['kode_kelas'],
                $s['angkatan'], $set['angkatan'] ?? $s['angkatan'], $jenis, $tahun, $ket);
        }
        $siswaModel->whereIn('nisn', $nisn)->set($set)->update();
        $this->db->transComplete();

        return redirect()->to(site_url('siswa') . '?' . http_build_query(['angkatan' => $angkatan, 'kelas' => $kelas]))
            ->with('sukses', count($nisn) . ' siswa berhasil diproses (' . strtolower($jenis) . ') dan dicatat di riwayat kelas.');
    }

    /** Hapus satu catatan riwayat kelas yang salah input (khusus administrator). */
    public function hapusRiwayat(int $id): RedirectResponse
    {
        if (level() !== 'superuser') {
            throw PageNotFoundException::forPageNotFound();
        }
        $r = $this->wajibAda(model(RiwayatKelasModel::class)->find($id));
        model(RiwayatKelasModel::class)->delete($id);

        return redirect()->to(site_url('siswa/detail/' . rawurlencode($r['nisn'])) . '#riwayat')->with('sukses', 'Catatan riwayat kelas dihapus.');
    }

    /** Halaman cetak daftar siswa sesuai filter. */
    public function cetak(): string
    {
        $angkatan = (string) $this->request->getGet('angkatan');
        $kelas    = (string) $this->request->getGet('kelas');
        $b        = model(SiswaModel::class)->lengkap();
        if ($kelas !== '') {
            $b->where('rb_siswa.kode_kelas', $kelas);
        }
        if ($angkatan !== '') {
            $b->where('rb_siswa.angkatan', $angkatan);
        }

        return view('siswa/cetak', [
            'kelas'    => $kelas !== '' ? model(KelasModel::class)->lengkap()->where('rb_kelas.kode_kelas', $kelas)->first() : null,
            'angkatan' => $angkatan,
            'baris'    => $kelas === '' && $angkatan === '' ? [] : $b->orderBy('rb_siswa.id_siswa', 'ASC')->findAll(),
            'sekolah'  => config('Sekolah'),
        ]);
    }

    /** Admin melihat jawaban penilaian diri seorang siswa. */
    public function penilaianDiri(string $nisn): string
    {
        $s = $this->wajibAda(model(SiswaModel::class)->detail($nisn));

        return view('siswa/penilaian_jawaban', [
            'judul'      => 'Jawaban Penilaian Diri',
            's'          => $s,
            'teman'      => null,
            'pertanyaan' => $this->jawabanPenilaian('diri', $s, null),
        ]);
    }

    /** Admin memilih teman sekelas untuk melihat penilaian teman dari siswa ini. */
    public function penilaianTeman(string $nisn): string
    {
        $s = $this->wajibAda(model(SiswaModel::class)->detail($nisn));

        return view('siswa/penilaian_teman', [
            'judul' => 'Penilaian Teman oleh ' . $s['nama'],
            's'     => $s,
            'teman' => $this->temanSekelas($s),
            'url'   => static fn ($t) => site_url('siswa/' . rawurlencode($s['nisn']) . '/penilaian-teman/' . rawurlencode($t['nisn'])),
            'labelTombol' => 'Lihat Penilaian',
        ]);
    }

    public function penilaianTemanDetail(string $nisn, string $nisnTeman): string
    {
        $s     = $this->wajibAda(model(SiswaModel::class)->detail($nisn));
        $teman = $this->wajibAda(model(SiswaModel::class)->detail($nisnTeman));

        return view('siswa/penilaian_jawaban', [
            'judul'      => 'Jawaban Penilaian Teman',
            's'          => $s,
            'teman'      => $teman,
            'pertanyaan' => $this->jawabanPenilaian('teman', $s, $teman['nisn']),
        ]);
    }

    // ------------------------------------------------------------------ Bantuan

    /**
     * Teman sekelas & seangkatan (tanpa dirinya sendiri).
     *
     * @return list<array<string, mixed>>
     */
    public static function temanSekelas(array $s): array
    {
        return model(SiswaModel::class)->lengkap()
            ->where('rb_siswa.kode_kelas', $s['kode_kelas'])
            ->where('rb_siswa.angkatan', $s['angkatan'])
            ->where('rb_siswa.nisn !=', $s['nisn'])
            ->orderBy('rb_siswa.id_siswa', 'ASC')
            ->findAll();
    }

    /**
     * Pertanyaan penilaian beserta jawaban siswa.
     *
     * @return list<array<string, mixed>>
     */
    public static function jawabanPenilaian(string $status, array $s, ?string $nisnTeman): array
    {
        $pertanyaan = model(PertanyaanPenilaianModel::class)->where('status', $status)->orderBy('id_pertanyaan_penilaian', 'DESC')->findAll();
        $b          = model(PertanyaanPenilaianJawabModel::class)
            ->where(['nisn' => $s['nisn'], 'status' => $status, 'kode_kelas' => $s['kode_kelas']]);
        if ($nisnTeman !== null) {
            $b->where('nisn_teman', $nisnTeman);
        }
        $jawaban = array_column($b->findAll(), 'jawaban', 'id_pertanyaan_penilaian');

        foreach ($pertanyaan as &$p) {
            $p['jawaban'] = $jawaban[$p['id_pertanyaan_penilaian']] ?? '';
        }

        return $pertanyaan;
    }

    private function bolehEdit(array $s): bool
    {
        return level() === 'superuser' || (level() === 'siswa' && $s['nisn'] === session('id'));
    }

    private function siswaUntukEdit(string $nisn): array
    {
        if (level() === 'siswa') {
            $nisn = (string) session('id');
        }
        $s = $this->wajibAda(model(SiswaModel::class)->detail($nisn), 'Siswa tidak ditemukan.');
        if (! $this->bolehEdit($s)) {
            throw PageNotFoundException::forPageNotFound('Anda tidak boleh mengubah data siswa ini.');
        }

        return $s;
    }

    /** @return array<string, string> */
    private function aturan(?array $lama): array
    {
        $unik = $lama === null ? 'is_unique[rb_siswa.nisn]' : 'is_unique[rb_siswa.nisn,id_siswa,' . (int) $lama['id_siswa'] . ']';

        return [
            'nisn'          => "required|max_length[20]|{$unik}",
            'nipd'          => 'permit_empty|max_length[10]',
            'nama'          => 'required|max_length[120]',
            'password'      => $lama === null ? 'required|min_length[4]' : 'permit_empty|min_length[4]',
            'email'         => 'permit_empty|valid_email',
            'tanggal_lahir' => 'permit_empty|valid_date[Y-m-d]',
            'foto'          => 'permit_empty|is_image[foto]|max_size[foto,2048]',
        ];
    }

    /** Ubah string kosong pada kolom angka menjadi 0 agar aman untuk kolom NOT NULL. */
    private function bersihkan(array $data): array
    {
        foreach (['kode_pos', 'tahun_lahir_ayah', 'tahun_lahir_ibu', 'tahun_lahir_wali', 'angkatan', 'id_jenis_kelamin', 'id_agama'] as $k) {
            if (array_key_exists($k, $data)) {
                $data[$k] = (int) $data[$k];
            }
        }

        return $data;
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
        if (trim((string) $foto) !== '' && basename((string) $foto) !== 'no-image.jpg' && is_file($path)) {
            @unlink($path);
        }
    }

    /** @return list<array<string, mixed>> */
    private function fieldData(bool $baru, bool $olehSiswa): array
    {
        $kunci = $olehSiswa; // siswa tidak boleh mengubah identitas akademik

        return [
            ['name' => 'nipd', 'label' => 'NIPD', 'readonly' => $kunci],
            ['name' => 'nisn', 'label' => 'NISN', 'rules' => 'required', 'readonly' => $kunci],
            ['name' => 'password', 'label' => 'Password', 'type' => 'password', 'rules' => $baru ? 'required' : ''],
            ['name' => 'nama', 'label' => 'Nama Siswa', 'rules' => 'required'],
            ['name' => 'kode_kelas', 'label' => 'Kelas', 'type' => $kunci ? 'static' : 'select', 'readonly' => $kunci,
                'options' => model(KelasModel::class)->opsi()],
            ['name' => 'angkatan', 'label' => 'Angkatan', 'type' => 'number', 'readonly' => $kunci],
            ['name' => 'kode_jurusan', 'label' => 'Jurusan', 'type' => $kunci ? 'static' : 'select', 'readonly' => $kunci,
                'options' => pilihan(model(JurusanModel::class)->findAll(), 'kode_jurusan', 'nama_jurusan', '- Pilih Jurusan -')],
            ['name' => 'alamat', 'label' => 'Alamat Siswa'],
            ['name' => 'rt', 'label' => 'RT'],
            ['name' => 'rw', 'label' => 'RW'],
            ['name' => 'dusun', 'label' => 'Dusun'],
            ['name' => 'kelurahan', 'label' => 'Kelurahan'],
            ['name' => 'kecamatan', 'label' => 'Kecamatan'],
            ['name' => 'kode_pos', 'label' => 'Kode Pos', 'type' => 'number'],
            ['name' => 'status_awal', 'label' => 'Status Awal'],
            ['name' => 'nik', 'label' => 'NIK'],
            ['name' => 'tempat_lahir', 'label' => 'Tempat Lahir'],
            ['name' => 'tanggal_lahir', 'label' => 'Tanggal Lahir', 'type' => 'date'],
            ['name' => 'id_jenis_kelamin', 'label' => 'Jenis Kelamin', 'type' => 'select',
                'options' => pilihan(model(JenisKelaminModel::class)->findAll(), 'id_jenis_kelamin', 'jenis_kelamin', '- Pilih Jenis Kelamin -')],
            ['name' => 'id_agama', 'label' => 'Agama', 'type' => 'select',
                'options' => pilihan(model(AgamaModel::class)->findAll(), 'id_agama', 'nama_agama', '- Pilih Agama -')],
            ['name' => 'kebutuhan_khusus', 'label' => 'Kebutuhan Khusus'],
            ['name' => 'jenis_tinggal', 'label' => 'Jenis Tinggal'],
            ['name' => 'alat_transportasi', 'label' => 'Transportasi'],
            ['name' => 'telepon', 'label' => 'No Telpon'],
            ['name' => 'hp', 'label' => 'No Handphone'],
            ['name' => 'email', 'label' => 'Alamat Email', 'type' => 'email'],
            ['name' => 'skhun', 'label' => 'SKHUN'],
            ['name' => 'penerima_kps', 'label' => 'Penerima KPS'],
            ['name' => 'no_kps', 'label' => 'No KPS'],
            ['name' => 'status_siswa', 'label' => 'Status Siswa', 'type' => 'radio', 'readonly' => $kunci,
                'options' => ['Aktif' => 'Aktif', 'Tidak Aktif' => 'Tidak Aktif']],
        ];
    }

    /** @return list<array<string, mixed>> */
    private function fieldOrtu(): array
    {
        $field = [];
        foreach (['ayah' => 'Ayah', 'ibu' => 'Ibu', 'wali' => 'Wali'] as $k => $label) {
            $field[] = ['name' => "nama_{$k}", 'label' => "Nama {$label}", 'separator' => true];
            $field[] = ['name' => "tahun_lahir_{$k}", 'label' => 'Tahun Lahir', 'type' => 'number'];
            $field[] = ['name' => "pendidikan_{$k}", 'label' => 'Pendidikan'];
            $field[] = ['name' => "pekerjaan_{$k}", 'label' => 'Pekerjaan'];
            $field[] = ['name' => "penghasilan_{$k}", 'label' => 'Penghasilan'];
            if ($k !== 'wali') {
                $field[] = ['name' => "kebutuhan_khusus_{$k}", 'label' => 'Kebutuhan Khusus'];
                $field[] = ['name' => "no_telpon_{$k}", 'label' => 'No Telpon'];
            }
        }

        return $field;
    }
}
