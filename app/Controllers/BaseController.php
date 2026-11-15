<?php

namespace App\Controllers;

use App\Models\JadwalPelajaranModel;
use App\Models\KelasModel;
use App\Models\KurikulumModel;
use App\Models\TahunAkademikModel;
use CodeIgniter\Controller;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Controller dasar: menyiapkan helper, koneksi database, dan data layout.
 */
abstract class BaseController extends Controller
{
    /**
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * @var list<string>
     */
    protected $helpers = ['url', 'form', 'text', 'siakad'];

    protected BaseConnection $db;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->db = db_connect();
    }

    /**
     * Render view di dalam layout utama AdminLTE.
     *
     * @param array<string, mixed> $data
     */
    protected function tampil(string $view, array $data = []): string
    {
        $data['judul'] ??= 'Dashboard';

        return view($view, $data);
    }

    /** Kode kurikulum yang sedang aktif (status_kurikulum = 'Ya'). */
    protected function kurikulumAktif(): int
    {
        return (int) (model(KurikulumModel::class)->aktif()['kode_kurikulum'] ?? 0);
    }

    protected function kembali(string $url, string $pesan = 'Data berhasil disimpan.'): RedirectResponse
    {
        return redirect()->to($url)->with('sukses', $pesan);
    }

    protected function gagal(string $url, string $pesan): RedirectResponse
    {
        return redirect()->to($url)->with('error', $pesan);
    }

    /**
     * Hentikan dengan 404 jika data tidak ditemukan.
     *
     * @template T
     *
     * @param T|null $data
     *
     * @return T
     */
    protected function wajibAda($data, string $pesan = 'Data tidak ditemukan.')
    {
        if ($data === null || $data === [] || $data === false) {
            throw PageNotFoundException::forPageNotFound($pesan);
        }

        return $data;
    }

    /** Tolak aksi tulis untuk level yang hanya boleh melihat (kepala sekolah). */
    protected function wajibBolehUbah(): void
    {
        if (! boleh_ubah()) {
            throw PageNotFoundException::forPageNotFound('Akses hanya-baca.');
        }
    }

    /**
     * Ambil input POST dan buang spasi di ujung string.
     *
     * @param list<string> $kolom
     *
     * @return array<string, mixed>
     */
    protected function inputPost(array $kolom): array
    {
        $data = [];
        foreach ($kolom as $k) {
            $v        = $this->request->getPost($k);
            $data[$k] = is_string($v) ? trim($v) : ($v ?? '');
        }

        return $data;
    }

    /**
     * Halaman "pilih jadwal pelajaran" yang dipakai banyak modul (absensi, journal, nilai, forum, dst).
     *
     * - Admin / kepala: memilih tahun akademik + kelas, semua jadwal ditampilkan.
     * - Guru: memilih tahun akademik, hanya jadwal yang diampu.
     * - Siswa: memilih tahun akademik, hanya jadwal kelasnya.
     *
     * @param callable(array): string               $aksi   HTML tombol aksi per jadwal
     * @param array<string, callable(array): string> $ekstra kolom tambahan: ['Judul' => fn ($row) => html]
     */
    protected function halamanPilihJadwal(string $judul, string $url, callable $aksi, array $ekstra = []): string
    {
        $level     = level();
        $tahunList = model(TahunAkademikModel::class)->semua();
        $tahun     = (string) $this->request->getGet('tahun');
        $kelas     = (string) $this->request->getGet('kelas');
        $filter    = ['kurikulum' => $this->kurikulumAktif()];

        if (in_array($level, ['guru', 'siswa'], true)) {
            $tahun = $tahun !== '' ? $tahun : (string) model(TahunAkademikModel::class)->bawaan();
            $filter += $level === 'guru' ? ['nip' => session('id')] : ['kelas' => session('kode_kelas')];
            $lengkap = $tahun !== '';
        } else {
            $filter['kelas'] = $kelas;
            $lengkap         = $tahun !== '' && $kelas !== '';
        }
        $filter['tahun'] = $tahun;

        return view('components/pilih_jadwal', [
            'judul'     => $judul,
            'url'       => $url,
            'pilihKelas' => ! in_array($level, ['guru', 'siswa'], true),
            'tahunOpsi' => pilihan($tahunList, 'id_tahun_akademik', 'nama_tahun', '- Pilih Tahun Akademik -'),
            'kelasOpsi' => model(KelasModel::class)->opsi(),
            'tahun'     => $tahun,
            'kelas'     => $kelas,
            'lengkap'   => $lengkap,
            'baris'     => $lengkap ? model(JadwalPelajaranModel::class)->daftar($filter) : [],
            'aksi'      => $aksi,
            'ekstra'    => $ekstra,
        ]);
    }

    /**
     * Ambil jadwal beserta detailnya dan pastikan pengguna boleh mengaksesnya.
     *
     * @return array<string, mixed>
     */
    protected function jadwal(int|string $kodejdwl): array
    {
        $model  = model(JadwalPelajaranModel::class);
        $jadwal = $this->wajibAda($model->detail($kodejdwl), 'Jadwal pelajaran tidak ditemukan.');

        if (! $model->bolehAkses($jadwal, pengguna())) {
            throw PageNotFoundException::forPageNotFound('Anda tidak memiliki akses ke jadwal ini.');
        }

        return $jadwal;
    }

    /** Hitung jumlah baris per kodejdwl pada sebuah tabel, untuk kolom "jumlah" di halaman pilih jadwal. */
    protected function hitungPerJadwal(string $tabel): callable
    {
        $hitung = array_column(
            $this->db->table($tabel)->select('kodejdwl, COUNT(*) AS total')->groupBy('kodejdwl')->get()->getResultArray(),
            'total',
            'kodejdwl'
        );

        return static fn (array $r): string => '<span class="text-red">' . (int) ($hitung[$r['kodejdwl']] ?? 0) . ' data</span>';
    }
}
