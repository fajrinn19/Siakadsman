<?php

namespace App\Controllers\Raport;

use App\Libraries\DataRaport;
use App\Libraries\Pdf;
use App\Models\RiwayatKelasModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\NilaiExtrakulikulerModel;
use App\Models\NilaiPrestasiModel;
use App\Models\NilaiSikapSemesterModel;
use App\Models\PredikatModel;
use CodeIgniter\Exceptions\PageNotFoundException;

/** Daftar siswa untuk cetak raport dan halaman-halaman cetaknya. */
class Cetak extends PerKelas
{
    private const HALAMAN = ['cover', '1', '2', '3', '4', '5', '6', 'merdeka'];

    /** Urutan halaman per format raport. */
    private const FORMAT = [
        'k13'     => ['cover', '1', '2', '3', '4', '5', '6'],
        'merdeka' => ['cover', '1', '2', 'merdeka'],
    ];

    public function index(): string
    {
        return view('raport/cetak_daftar', ['judul' => 'Cetak Raport Semester', 'segmen' => 'raport/cetak', 'uts' => false] + $this->filterKelas());
    }

    public function uts(): string
    {
        return view('raport/cetak_daftar', ['judul' => 'Cetak Raport UTS', 'segmen' => 'raport/cetak-uts', 'uts' => true] + $this->filterKelas());
    }

    public function halaman(string $hal, string $nisn): string
    {
        if (! in_array($hal, self::HALAMAN, true)) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $this->renderHalaman($hal, $nisn, (string) $this->request->getGet('tahun'), (string) $this->request->getGet('kelas'));
    }

    /** Raport lengkap satu siswa dalam satu file PDF. */
    public function pdf(string $nisn): ResponseInterface
    {
        [$tahun, $kelas, $format] = $this->parameterPdf();
        $halaman = array_map(fn ($h) => $this->renderHalaman($h, $nisn, $tahun, $kelas), self::FORMAT[$format]);

        return $this->kirimPdf(Pdf::dariHalaman($halaman), "raport_{$nisn}_{$tahun}.pdf");
    }

    /** Raport seluruh siswa satu kelas dalam satu file PDF. */
    public function pdfKelas(): ResponseInterface
    {
        [$tahun, $kelas, $format] = $this->parameterPdf();
        if ($tahun === '' || $kelas === '') {
            throw PageNotFoundException::forPageNotFound('Pilih tahun akademik dan kelas.');
        }
        set_time_limit(300);

        $halaman = [];
        foreach ($this->anggotaKelas($kelas) as $s) {
            foreach (self::FORMAT[$format] as $h) {
                $halaman[] = $this->renderHalaman($h, $s['nisn'], $tahun, $kelas);
            }
        }
        if ($halaman === []) {
            throw PageNotFoundException::forPageNotFound('Kelas ini tidak memiliki siswa.');
        }

        return $this->kirimPdf(Pdf::dariHalaman($halaman), "raport_kelas_{$kelas}_{$tahun}.pdf");
    }

    /** @return array{0: string, 1: string, 2: string} */
    private function parameterPdf(): array
    {
        $format = (string) $this->request->getGet('format');

        return [(string) $this->request->getGet('tahun'), (string) $this->request->getGet('kelas'), isset(self::FORMAT[$format]) ? $format : 'k13'];
    }

    private function kirimPdf(string $isi, string $nama): ResponseInterface
    {
        return $this->response->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . preg_replace('/[^A-Za-z0-9._-]+/', '_', $nama) . '"')
            ->setBody($isi);
    }

    private function renderHalaman(string $hal, string $nisn, string $tahun, string $kelas): string
    {
        $d = $this->data($nisn, $tahun, $kelas);

        $d += match ($hal) {
            '2'       => ['masuk' => model(RiwayatKelasModel::class)->diterima($nisn)],
            '3'       => ['sikap' => model(NilaiSikapSemesterModel::class)->where(['id_tahun_akademik' => $d['tahun'], 'nisn' => $nisn, 'kode_kelas' => $d['kelas']])->first() ?? []],
            '4', '5'  => ['kelompok' => DataRaport::nilaiRaport($nisn, $d['kelas'], $d['tahun']), 'predikat' => model(PredikatModel::class)->untukKelas($d['kelas'])],
            '6', 'merdeka' => [
                'kelompok' => $hal === 'merdeka' ? DataRaport::nilaiRaport($nisn, $d['kelas'], $d['tahun']) : [],
                'ekstra'   => model(NilaiExtrakulikulerModel::class)->where(['id_tahun_akademik' => $d['tahun'], 'nisn' => $nisn, 'kode_kelas' => $d['kelas']])->findAll(),
                'prestasi' => model(NilaiPrestasiModel::class)->where(['id_tahun_akademik' => $d['tahun'], 'nisn' => $nisn, 'kode_kelas' => $d['kelas']])->findAll(),
                'absen'    => DataRaport::ketidakhadiran($nisn, $d['kelas'], $d['tahun']),
                'sikap'    => model(NilaiSikapSemesterModel::class)->where(['id_tahun_akademik' => $d['tahun'], 'nisn' => $nisn, 'kode_kelas' => $d['kelas']])->first() ?? [],
            ],
            default => [],
        };

        return view('raport/print/hal_' . $hal, $d);
    }

    public function printUts(string $nisn): string
    {
        $d = $this->data($nisn, (string) $this->request->getGet('tahun'), (string) $this->request->getGet('kelas'));

        return view('raport/print/uts', $d + [
            'kelompok' => DataRaport::nilaiUts($nisn, $d['kelas'], $d['tahun']),
            'predikat' => model(PredikatModel::class)->untukKelas($d['kelas']),
        ]);
    }

    /** Data umum halaman cetak: siswa, kelas, tahun akademik, identitas sekolah. */
    private function data(string $nisn, string $tahun, string $kelas): array
    {
        $s     = $this->wajibAda(DataRaport::siswa($nisn), 'Siswa tidak ditemukan.');
        $kelas = $kelas !== '' ? $kelas : (string) $s['kode_kelas'];

        // Guru hanya boleh mencetak raport siswa di kelas yang diajarnya / diwalikannya.
        if (level() === 'guru' && ! $this->guruTerkaitKelas($kelas)) {
            throw PageNotFoundException::forPageNotFound('Anda tidak mengajar di kelas ini.');
        }

        return [
            'judul'     => 'Raport ' . $s['nama'] . ' - ' . $s['nisn'],
            's'         => $s,
            'kelas'     => $kelas,
            'tahun'     => $tahun,
            't'         => DataRaport::tahun($tahun) ?? ['keterangan' => '', 'nama_tahun' => ''],
            'semester'  => $tahun !== '' ? semester_dari_tahun($tahun) : '',
            'iden'      => DataRaport::identitas(),
            'sekolah'   => config('Sekolah'),
            'wali'      => ['nama' => $s['walikelas'], 'nip' => $s['nip_wali']],
        ];
    }

    private function guruTerkaitKelas(string $kelas): bool
    {
        $nip = (string) session('id');

        return $this->db->table('rb_jadwal_pelajaran')->where(['kode_kelas' => $kelas, 'nip' => $nip])->countAllResults() > 0
            || $this->db->table('rb_kelas')->where(['kode_kelas' => $kelas, 'nip' => $nip])->countAllResults() > 0;
    }
}
