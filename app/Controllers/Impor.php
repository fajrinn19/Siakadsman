<?php

namespace App\Controllers;

use App\Libraries\Excel;
use App\Libraries\Password;
use App\Models\KelasModel;
use App\Models\RiwayatKelasModel;
use App\Models\SiswaModel;
use App\Models\TahunAkademikModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

/** Impor data siswa dari Excel/CSV. */
class Impor extends BaseController
{
    private const KOLOM = ['nisn', 'nipd', 'nama', 'password', 'kode_kelas', 'angkatan', 'jenis_kelamin', 'agama',
        'tempat_lahir', 'tanggal_lahir', 'alamat', 'hp', 'email', 'nama_ayah', 'no_telpon_ayah', 'nama_ibu', 'no_telpon_ibu'];

    public function index(): string
    {
        return view('impor/siswa', ['judul' => 'Impor Data Siswa', 'hasil' => session('hasil_impor')]);
    }

    public function template(): ResponseInterface
    {
        $contoh = ['0012345678', '1234', 'Nama Siswa Contoh', '', 'X.MIPA.1', date('Y'), 'L', 'Islam',
            'Sinjai', '2010-01-31', 'Jl. Contoh No. 1', '081234567890', '', 'Nama Ayah', '081200000001', 'Nama Ibu', ''];

        return Excel::unduh(Excel::buat('siswa', self::KOLOM, [$contoh]), 'template_impor_siswa.xlsx');
    }

    public function proses(): RedirectResponse
    {
        $this->wajibBolehUbah();
        if (! $this->validate(['file' => 'uploaded[file]|ext_in[file,xlsx,xls,csv]|max_size[file,5120]'])) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        try {
            $baris = Excel::baca($this->request->getFile('file')->getTempName());
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'File tidak bisa dibaca: ' . $e->getMessage());
        }

        $perbarui = (bool) $this->request->getPost('perbarui');
        $kelas    = array_column(model(KelasModel::class)->findAll(), 'kode_kelas', 'kode_kelas');
        $agama    = array_change_key_case(array_column($this->db->table('rb_agama')->get()->getResultArray(), 'id_agama', 'nama_agama'));
        $tahun    = (string) model(TahunAkademikModel::class)->bawaan();
        $model    = model(SiswaModel::class);
        $hasil    = ['baru' => 0, 'diperbarui' => 0, 'dilewati' => 0, 'error' => []];

        foreach ($baris as $i => $r) {
            $no   = $i + 2; // nomor baris di Excel (baris 1 = header)
            $nisn = preg_replace('/\s+/', '', $r['nisn'] ?? '');
            $nama = $r['nama'] ?? '';
            if ($nisn === '' || $nama === '') {
                $hasil['error'][] = "Baris {$no}: NISN dan nama wajib diisi.";

                continue;
            }
            $kodeKelas = $r['kode_kelas'] ?? '';
            if ($kodeKelas !== '' && ! isset($kelas[$kodeKelas])) {
                $hasil['error'][] = "Baris {$no} ({$nama}): kode kelas \"{$kodeKelas}\" tidak ditemukan.";

                continue;
            }
            $tgl = $r['tanggal_lahir'] ?? '';
            if ($tgl !== '' && is_numeric($tgl)) {
                $tgl = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((float) $tgl)->format('Y-m-d');
            }
            if ($tgl !== '' && ! preg_match('/^\d{4}-\d{2}-\d{2}$/', $tgl)) {
                $hasil['error'][] = "Baris {$no} ({$nama}): format tanggal lahir harus YYYY-MM-DD.";

                continue;
            }

            $data = array_filter([
                'nipd'           => $r['nipd'] ?? '',
                'nama'           => $nama,
                'kode_kelas'     => $kodeKelas,
                'angkatan'       => (int) ($r['angkatan'] ?? 0) ?: null,
                'id_jenis_kelamin' => match (strtoupper(substr($r['jenis_kelamin'] ?? '', 0, 1))) { 'L' => 1, 'P' => 2, default => null },
                'id_agama'       => $agama[strtolower($r['agama'] ?? '')] ?? null,
                'tempat_lahir'   => $r['tempat_lahir'] ?? '',
                'tanggal_lahir'  => $tgl,
                'alamat'         => $r['alamat'] ?? '',
                'hp'             => $r['hp'] ?? '',
                'email'          => $r['email'] ?? '',
                'nama_ayah'      => $r['nama_ayah'] ?? '',
                'no_telpon_ayah' => $r['no_telpon_ayah'] ?? '',
                'nama_ibu'       => $r['nama_ibu'] ?? '',
                'no_telpon_ibu'  => $r['no_telpon_ibu'] ?? '',
            ], static fn ($v) => $v !== null && $v !== '');

            $ada = $model->cariNisn($nisn);
            if ($ada !== null) {
                if (! $perbarui) {
                    $hasil['dilewati']++;

                    continue;
                }
                $model->update($ada['id_siswa'], $data);
                if (isset($data['kode_kelas']) && $data['kode_kelas'] !== $ada['kode_kelas']) {
                    model(RiwayatKelasModel::class)->catat($nisn, (string) $ada['kode_kelas'], $data['kode_kelas'], $ada['angkatan'], $data['angkatan'] ?? $ada['angkatan'], 'Perubahan Data', $tahun, 'Impor Excel');
                }
                $hasil['diperbarui']++;

                continue;
            }

            // Password kosong = NISN; pengguna diwajibkan menggantinya saat login pertama.
            $model->insert($data + [
                'nisn'         => $nisn,
                'password'     => Password::hash(($r['password'] ?? '') !== '' ? $r['password'] : $nisn),
                'status_siswa' => 'Aktif',
                'tingkat'      => '',
                'id_sesi'      => 0,
                'foto'         => '',
            ]);
            model(RiwayatKelasModel::class)->catat($nisn, '', $kodeKelas, 0, $data['angkatan'] ?? 0, 'Masuk', $tahun, 'Impor Excel');
            $hasil['baru']++;
        }

        return redirect()->to(site_url('siswa/impor'))->with('hasil_impor', $hasil);
    }
}
