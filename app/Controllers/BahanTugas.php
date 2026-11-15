<?php

namespace App\Controllers;

use App\Models\ElearningJawabModel;
use App\Models\ElearningModel;
use App\Models\KategoriElearningModel;
use App\Models\SiswaModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\DownloadResponse;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * E-learning: guru mengunggah bahan / tugas per jadwal, siswa mengunduh dan mengirim jawaban.
 * File disimpan di writable/uploads/tugas (tidak bisa diakses langsung dari web).
 */
class BahanTugas extends BaseController
{
    private const FOLDER = WRITEPATH . 'uploads/tugas';

    private const KATEGORI_TUGAS = 2;

    public function index(): string
    {
        return $this->halamanPilihJadwal('Bahan dan Tugas', site_url('bahan-tugas'), static fn ($r) =>
            '<a class="btn btn-success btn-xs" href="' . site_url('bahan-tugas/' . $r['kodejdwl']) . '"><span class="glyphicon glyphicon-th"></span> Tampilkan</a>',
            ['Jumlah' => $this->hitungPerJadwal('rb_elearning')]);
    }

    public function daftar(int $kodejdwl): string
    {
        $jadwal = $this->jadwal($kodejdwl);
        $baris  = model(ElearningModel::class)
            ->select('rb_elearning.*, k.nama_kategori_elearning')
            ->join('rb_kategori_elearning k', 'rb_elearning.id_kategori_elearning = k.id_kategori_elearning', 'left')
            ->where('kodejdwl', $kodejdwl)->orderBy('id_elearning', 'ASC')->findAll();

        $terkirim = [];
        if (level() === 'siswa' && $baris !== []) {
            $terkirim = array_column(
                model(ElearningJawabModel::class)->where('nisn', session('id'))->whereIn('id_elearning', array_column($baris, 'id_elearning'))->findAll(),
                'waktu',
                'id_elearning'
            );
        }

        return view('bahan_tugas/daftar', [
            'judul'    => 'Bahan dan Tugas',
            'jadwal'   => $jadwal,
            'baris'    => $baris,
            'terkirim' => $terkirim,
            'kelola'   => in_array(level(), ['guru', 'superuser'], true),
        ]);
    }

    public function tambah(int $kodejdwl): string
    {
        $this->wajibBolehUbah();

        return $this->form($this->jadwal($kodejdwl), [
            'tanggal_tugas'   => date('Y-m-d\TH:i'),
            'tanggal_selesai' => date('Y-m-d\TH:i', strtotime('+7 days')),
        ], site_url("bahan-tugas/{$kodejdwl}/tambah"), true);
    }

    public function simpan(int $kodejdwl): RedirectResponse
    {
        $this->wajibBolehUbah();
        $this->jadwal($kodejdwl);
        if (! $this->validate($this->aturan(true))) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        model(ElearningModel::class)->insert($this->input() + [
            'kodejdwl'    => $kodejdwl,
            'file_upload' => $this->unggah('file') ?? '',
        ]);

        return $this->kembali(site_url("bahan-tugas/{$kodejdwl}"), 'Bahan / tugas berhasil ditambahkan.');
    }

    public function edit(int $kodejdwl, int $id): string
    {
        $this->wajibBolehUbah();
        $jadwal = $this->jadwal($kodejdwl);
        $row    = $this->wajibAda(model(ElearningModel::class)->where('kodejdwl', $kodejdwl)->find($id));
        $row['tanggal_tugas']   = str_replace(' ', 'T', substr($row['tanggal_tugas'], 0, 16));
        $row['tanggal_selesai'] = str_replace(' ', 'T', substr($row['tanggal_selesai'], 0, 16));

        return $this->form($jadwal, $row, site_url("bahan-tugas/{$kodejdwl}/edit/{$id}"), false);
    }

    public function update(int $kodejdwl, int $id): RedirectResponse
    {
        $this->wajibBolehUbah();
        $this->jadwal($kodejdwl);
        $lama = $this->wajibAda(model(ElearningModel::class)->where('kodejdwl', $kodejdwl)->find($id));
        if (! $this->validate($this->aturan(false))) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->input();
        if (($file = $this->unggah('file')) !== null) {
            $data['file_upload'] = $file;
            $this->hapusFile($lama['file_upload']);
        }
        model(ElearningModel::class)->update($id, $data);

        return $this->kembali(site_url("bahan-tugas/{$kodejdwl}"), 'Bahan / tugas berhasil diperbarui.');
    }

    public function hapus(int $kodejdwl, int $id): RedirectResponse
    {
        $this->wajibBolehUbah();
        $this->jadwal($kodejdwl);
        $row = $this->wajibAda(model(ElearningModel::class)->where('kodejdwl', $kodejdwl)->find($id));

        model(ElearningModel::class)->delete($id);
        $this->hapusFile($row['file_upload']);

        return $this->kembali(site_url("bahan-tugas/{$kodejdwl}"), 'Bahan / tugas berhasil dihapus.');
    }

    /** Guru melihat daftar siswa yang sudah mengirim jawaban tugas. */
    public function jawaban(int $kodejdwl, int $id): string
    {
        $jadwal = $this->jadwal($kodejdwl);
        $tugas  = $this->wajibAda(model(ElearningModel::class)->where('kodejdwl', $kodejdwl)->find($id));
        $baris  = model(ElearningJawabModel::class)
            ->select('rb_elearning_jawab.*, s.nama, s.nipd')
            ->join('rb_siswa s', 'rb_elearning_jawab.nisn = s.nisn', 'left')
            ->where('id_elearning', $id)->orderBy('waktu', 'ASC')->findAll();

        return view('bahan_tugas/jawaban', [
            'judul'      => 'Jawaban Tugas',
            'jadwal'     => $jadwal,
            'tugas'      => $tugas,
            'baris'      => $baris,
            'jumlahSiswa' => model(SiswaModel::class)->where('kode_kelas', $jadwal['kode_kelas'])->countAllResults(),
        ]);
    }

    /** Siswa mengirim jawaban tugas (hanya sekali, sebelum batas waktu). */
    public function kirim(int $kodejdwl, int $id): string|RedirectResponse
    {
        $jadwal = $this->jadwal($kodejdwl);
        $tugas  = $this->tugasTerbuka($kodejdwl, $id);
        if ($tugas instanceof RedirectResponse) {
            return $tugas;
        }

        return view('bahan_tugas/kirim', ['judul' => 'Kirim Tugas', 'jadwal' => $jadwal, 'tugas' => $tugas]);
    }

    public function simpanKiriman(int $kodejdwl, int $id): RedirectResponse
    {
        $this->jadwal($kodejdwl);
        $tugas = $this->tugasTerbuka($kodejdwl, $id);
        if ($tugas instanceof RedirectResponse) {
            return $tugas;
        }
        if (! $this->validate(['file' => 'uploaded[file]|max_size[file,10240]|ext_in[file,pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,zip,rar,txt]'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        model(ElearningJawabModel::class)->insert([
            'id_elearning' => $id,
            'nisn'         => (string) session('id'),
            'keterangan'   => trim((string) $this->request->getPost('keterangan')),
            'file_tugas'   => $this->unggah('file') ?? '',
            'waktu'        => date('Y-m-d H:i:s'),
        ]);

        return $this->kembali(site_url("bahan-tugas/{$kodejdwl}"), 'Tugas berhasil dikirim.');
    }

    public function unduhBahan(int $id): DownloadResponse
    {
        $row = $this->wajibAda(model(ElearningModel::class)->find($id));
        $this->jadwal($row['kodejdwl']);

        return $this->unduh($row['file_upload']);
    }

    public function unduhJawaban(int $id): DownloadResponse
    {
        $jawab = $this->wajibAda(model(ElearningJawabModel::class)->find($id));
        $tugas = $this->wajibAda(model(ElearningModel::class)->find($jawab['id_elearning']));
        $this->jadwal($tugas['kodejdwl']);
        if (level() === 'siswa' && $jawab['nisn'] !== session('id')) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $this->unduh($jawab['file_tugas']);
    }

    // ------------------------------------------------------------------ Bantuan

    /** Tugas yang masih bisa dikirim oleh siswa ini, atau redirect dengan pesan. */
    private function tugasTerbuka(int $kodejdwl, int $id): array|RedirectResponse
    {
        $tugas  = $this->wajibAda(model(ElearningModel::class)->where('kodejdwl', $kodejdwl)->find($id));
        $kembali = site_url("bahan-tugas/{$kodejdwl}");

        if ((int) $tugas['id_kategori_elearning'] !== self::KATEGORI_TUGAS) {
            return $this->gagal($kembali, 'Item ini adalah bahan ajar, bukan tugas.');
        }
        if (self::waktuHabis($tugas)) {
            return $this->gagal($kembali, 'Maaf, batas waktu pengiriman tugas sudah lewat.');
        }
        if (model(ElearningJawabModel::class)->where(['id_elearning' => $id, 'nisn' => session('id')])->countAllResults() > 0) {
            return $this->gagal($kembali, 'Anda sudah mengirimkan tugas ini sebelumnya.');
        }

        return $tugas;
    }

    public static function waktuHabis(array $tugas): bool
    {
        $batas = (string) $tugas['tanggal_selesai'];

        return tgl_valid($batas) && strtotime($batas) < time();
    }

    private function unduh(string $nama): DownloadResponse
    {
        $nama = basename($nama);
        $path = self::FOLDER . '/' . $nama;
        if ($nama === '' || ! is_file($path)) {
            throw PageNotFoundException::forPageNotFound('File tidak ditemukan.');
        }

        return $this->response->download($path, null)->setFileName(preg_replace('/^\d{14}-/', '', $nama));
    }

    private function unggah(string $field): ?string
    {
        $file = $this->request->getFile($field);
        if ($file === null || ! $file->isValid() || $file->hasMoved()) {
            return null;
        }
        $aman = preg_replace('/[^A-Za-z0-9._-]+/', '_', $file->getClientName());
        $nama = date('YmdHis') . '-' . substr(bin2hex(random_bytes(3)), 0, 6) . '-' . $aman;
        $file->move(self::FOLDER, $nama);

        return $nama;
    }

    private function hapusFile(?string $nama): void
    {
        $path = self::FOLDER . '/' . basename((string) $nama);
        if (trim((string) $nama) !== '' && is_file($path)) {
            @unlink($path);
        }
    }

    private function form(array $jadwal, array $row, string $action, bool $baru): string
    {
        return view('bahan_tugas/form', [
            'judul'  => ($baru ? 'Tambah' : 'Edit') . ' Bahan dan Tugas',
            'jadwal' => $jadwal,
            'row'    => $row,
            'action' => $action,
            'baru'   => $baru,
            'field'  => [
                ['name' => 'id_kategori_elearning', 'label' => 'Kategori', 'type' => 'select', 'rules' => 'required',
                    'options' => pilihan(model(KategoriElearningModel::class)->findAll(), 'id_kategori_elearning', 'nama_kategori_elearning', '- Pilih Kategori -')],
                ['name' => 'nama_file', 'label' => 'Judul', 'rules' => 'required'],
                ['name' => 'tanggal_tugas', 'label' => 'Waktu Mulai', 'type' => 'datetime-local'],
                ['name' => 'tanggal_selesai', 'label' => 'Batas Waktu', 'type' => 'datetime-local', 'help' => 'Untuk tugas: siswa tidak bisa mengirim jawaban setelah batas waktu.'],
                ['name' => 'keterangan', 'label' => 'Keterangan', 'type' => 'textarea', 'rows' => 3],
            ],
        ]);
    }

    /** @return array<string, string> */
    private function aturan(bool $baru): array
    {
        return [
            'id_kategori_elearning' => 'required|is_natural_no_zero',
            'nama_file'             => 'required|max_length[255]',
            'file'                  => 'permit_empty|max_size[file,20480]|ext_in[file,pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,gif,zip,rar,txt,mp4]',
        ];
    }

    /** @return array<string, mixed> */
    private function input(): array
    {
        $data = $this->inputPost(['id_kategori_elearning', 'nama_file', 'tanggal_tugas', 'tanggal_selesai', 'keterangan']);
        foreach (['tanggal_tugas', 'tanggal_selesai'] as $k) {
            $data[$k] = $data[$k] !== '' ? date('Y-m-d H:i:s', strtotime($data[$k])) : '0000-00-00 00:00:00';
        }

        return $data;
    }
}
