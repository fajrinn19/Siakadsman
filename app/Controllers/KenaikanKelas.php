<?php

namespace App\Controllers;

use App\Models\KelasModel;
use App\Models\RiwayatKelasModel;
use App\Models\SiswaModel;
use App\Models\TahunAkademikModel;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * Wizard kenaikan kelas akhir tahun ajaran:
 * 1) petakan kelas asal → kelas tujuan / Lulus, 2) pratinjau & kecualikan siswa tinggal kelas, 3) proses.
 */
class KenaikanKelas extends BaseController
{
    private const LULUS = '__lulus__';

    public function index(): string
    {
        $kelas  = model(KelasModel::class)->semua();
        $jumlah = array_column($this->db->table('rb_siswa')->select('kode_kelas, COUNT(*) AS total')
            ->where('status_siswa', 'Aktif')->groupBy('kode_kelas')->get()->getResultArray(), 'total', 'kode_kelas');
        $kode   = array_column($kelas, 'kode_kelas');

        foreach ($kelas as &$k) {
            $k['jumlah'] = (int) ($jumlah[$k['kode_kelas']] ?? 0);
            $k['saran']  = $this->saranTujuan($k['kode_kelas'], $kode);
        }

        return view('kenaikan/peta', [
            'judul'     => 'Kenaikan Kelas',
            'kelas'     => array_values(array_filter($kelas, static fn ($k) => $k['jumlah'] > 0)),
            'opsi'      => ['' => '— Tidak diproses —', self::LULUS => '🎓 Lulus'] + model(KelasModel::class)->opsi(null),
            'tahunOpsi' => pilihan(model(TahunAkademikModel::class)->semua(), 'id_tahun_akademik', 'nama_tahun', '- Tahun Akademik Baru -'),
            'tahun'     => (string) model(TahunAkademikModel::class)->bawaan(),
        ]);
    }

    /** Langkah 2: daftar siswa per kelas yang akan diproses. */
    public function pratinjau(): string|RedirectResponse
    {
        $this->wajibBolehUbah();
        $peta = array_filter((array) $this->request->getPost('peta'), static fn ($v) => $v !== '');
        if ($peta === []) {
            return redirect()->to(site_url('kenaikan-kelas'))->with('error', 'Pilih minimal satu kelas tujuan.');
        }

        $grup = [];
        foreach ($peta as $asal => $tujuan) {
            $grup[] = [
                'asal'   => (string) $asal,
                'tujuan' => (string) $tujuan,
                'siswa'  => model(SiswaModel::class)->where(['kode_kelas' => $asal, 'status_siswa' => 'Aktif'])->orderBy('nama', 'ASC')->findAll(),
            ];
        }

        return view('kenaikan/pratinjau', [
            'judul'      => 'Kenaikan Kelas — Pratinjau',
            'grup'       => $grup,
            'lulus'      => self::LULUS,
            'tahun'      => (string) $this->request->getPost('tahun'),
            'keterangan' => trim((string) $this->request->getPost('keterangan')),
        ]);
    }

    /** Langkah 3: proses kenaikan, kelulusan, dan tinggal kelas. */
    public function proses(): RedirectResponse
    {
        $this->wajibBolehUbah();
        $peta  = array_filter((array) $this->request->getPost('peta'), static fn ($v) => $v !== '');
        $ikut  = array_flip((array) $this->request->getPost('ikut'));
        $tahun = (string) $this->request->getPost('tahun');
        $ket   = trim((string) $this->request->getPost('keterangan')) ?: 'Kenaikan kelas akhir tahun ajaran';

        $siswaModel = model(SiswaModel::class);
        $riwayat    = model(RiwayatKelasModel::class);
        $hitung     = ['naik' => 0, 'lulus' => 0, 'tinggal' => 0];

        // Ambil semua siswa lebih dulu, baru dipindahkan, agar siswa yang baru naik tidak ikut terproses lagi.
        $daftar = [];
        foreach ($peta as $asal => $tujuan) {
            $daftar[(string) $asal] = [(string) $tujuan, $siswaModel->where(['kode_kelas' => $asal, 'status_siswa' => 'Aktif'])->findAll()];
        }

        $this->db->transStart();
        foreach ($daftar as $asal => [$tujuan, $siswa]) {
            foreach ($siswa as $s) {
                if (! isset($ikut[$s['nisn']])) {
                    $riwayat->catat($s['nisn'], $asal, $asal, $s['angkatan'], $s['angkatan'], 'Tinggal Kelas', $tahun, $ket);
                    $hitung['tinggal']++;
                } elseif ($tujuan === self::LULUS) {
                    $siswaModel->update($s['id_siswa'], ['status_siswa' => 'Tidak Aktif']);
                    $riwayat->catat($s['nisn'], $asal, '', $s['angkatan'], $s['angkatan'], 'Lulus', $tahun, $ket);
                    $hitung['lulus']++;
                } else {
                    $siswaModel->update($s['id_siswa'], ['kode_kelas' => $tujuan]);
                    $riwayat->catat($s['nisn'], $asal, $tujuan, $s['angkatan'], $s['angkatan'], 'Naik Kelas', $tahun, $ket);
                    $hitung['naik']++;
                }
            }
        }
        $this->db->transComplete();

        return $this->kembali(site_url('kenaikan-kelas'),
            "Selesai: {$hitung['naik']} siswa naik kelas, {$hitung['lulus']} lulus, {$hitung['tinggal']} tinggal kelas. Semua tercatat di riwayat kelas.");
    }

    /** Daftar alumni (siswa yang tercatat lulus). */
    public function alumni(): string
    {
        $baris = $this->db->table('rb_riwayat_kelas r')
            ->select('r.waktu, r.kode_kelas_asal, r.id_tahun_akademik, s.nisn, s.nipd, s.nama, s.angkatan, t.nama_tahun')
            ->join('rb_siswa s', 'r.nisn = s.nisn')
            ->join('rb_tahun_akademik t', 'r.id_tahun_akademik = t.id_tahun_akademik', 'left')
            ->where('r.jenis', 'Lulus')
            ->orderBy('r.waktu', 'DESC')
            ->get()->getResultArray();

        return view('kenaikan/alumni', ['judul' => 'Data Alumni', 'baris' => $baris]);
    }

    /** Tebak kelas tujuan dari kode: X.* → XI.*, XI.* → XII.*, XII.* → Lulus. */
    private function saranTujuan(string $kode, array $semuaKode): string
    {
        foreach (['XII' => null, 'XI' => 'XII', 'X' => 'XI'] as $dari => $ke) {
            if (preg_match('/^' . $dari . '([.\-].*)$/', $kode, $m)) {
                if ($ke === null) {
                    return self::LULUS;
                }

                return in_array($ke . $m[1], $semuaKode, true) ? $ke . $m[1] : '';
            }
        }

        return '';
    }
}
