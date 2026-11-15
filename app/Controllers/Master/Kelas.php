<?php

namespace App\Controllers\Master;

use App\Models\GuruModel;
use App\Models\JurusanModel;
use App\Models\KelasModel;
use App\Models\RuanganModel;
use App\Models\SiswaModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class Kelas extends CrudController
{
    protected string $modelClass = KelasModel::class;
    protected string $judul      = 'Data Kelas';
    protected string $segmen     = 'kelas';

    protected function daftar(array $filter): array
    {
        $jumlah = array_column(
            $this->db->table('rb_siswa')->select('kode_kelas, COUNT(*) AS total')->groupBy('kode_kelas')->get()->getResultArray(),
            'total',
            'kode_kelas'
        );

        $rows = model(KelasModel::class)->lengkap()->orderBy('rb_kelas.kode_kelas', 'DESC')->findAll();
        foreach ($rows as &$r) {
            $r['jumlah_siswa'] = (int) ($jumlah[$r['kode_kelas']] ?? 0);
        }

        return $rows;
    }

    protected function kolom(): array
    {
        return [
            'kode_kelas'   => 'Kode Kelas',
            'nama_kelas'   => 'Nama Kelas',
            'nama_guru'    => 'Wali Kelas',
            'nama_jurusan' => 'Jurusan',
            'nama_ruangan' => 'Ruangan',
            'nama_gedung'  => 'Gedung',
            'jumlah_siswa' => ['label' => 'Jumlah Siswa', 'format' => static fn ($r) => $r['jumlah_siswa'] . ' Orang'],
        ];
    }

    protected function field(): array
    {
        return [
            ['name' => 'kode_kelas', 'label' => 'Kode Kelas', 'rules' => 'required|max_length[10]'],
            ['name' => 'nama_kelas', 'label' => 'Nama Kelas', 'rules' => 'required|max_length[20]'],
            ['name' => 'nip', 'label' => 'Wali Kelas', 'type' => 'select', 'options' => static fn () => model(GuruModel::class)->opsi('- Pilih Wali Kelas -')],
            ['name' => 'kode_jurusan', 'label' => 'Jurusan', 'type' => 'select',
                'options' => static fn () => pilihan(model(JurusanModel::class)->findAll(), 'kode_jurusan', 'nama_jurusan', '- Pilih Jurusan -')],
            ['name' => 'kode_ruangan', 'label' => 'Ruangan', 'type' => 'select',
                'options' => static fn () => pilihan(
                    model(RuanganModel::class)->select('rb_ruangan.*, g.nama_gedung')->join('rb_gedung g', 'rb_ruangan.kode_gedung = g.kode_gedung', 'left')->findAll(),
                    'kode_ruangan',
                    static fn ($r) => trim(($r['nama_gedung'] ?? '') . ' - ' . $r['nama_ruangan'], ' -'),
                    '- Pilih Ruangan -'
                )],
            ['name' => 'aktif', 'label' => 'Aktif', 'type' => 'radio', 'options' => ['Ya' => 'Ya', 'Tidak' => 'Tidak']],
        ];
    }

    protected function aksiTambahan(array $row): string
    {
        return '<a class="btn btn-success btn-xs" title="Unduh daftar siswa (Excel)" href="' . site_url('kelas/excel/' . rawurlencode($row['kode_kelas'])) . '"><i class="fa fa-file-excel-o"></i> Excel</a>';
    }

    protected function sebelumHapus(string $id): ?string
    {
        return model(SiswaModel::class)->where('kode_kelas', $id)->countAllResults() > 0
            ? 'Kelas tidak dapat dihapus karena masih memiliki siswa!' : null;
    }

    /** Unduh daftar siswa satu kelas dalam format Excel (tabel HTML .xls). */
    public function excel(string $kode): ResponseInterface|RedirectResponse
    {
        $kelas = $this->wajibAda(model(KelasModel::class)->lengkap()->where('rb_kelas.kode_kelas', $kode)->first());
        $siswa = model(SiswaModel::class)->lengkap()->where('rb_siswa.kode_kelas', $kode)->orderBy('rb_siswa.nama', 'ASC')->findAll();

        if ($siswa === []) {
            return $this->gagal(site_url('kelas'), 'Kelas tidak memiliki siswa, tidak ada data untuk diekspor!');
        }

        $nama = 'Daftar_Siswa_Kelas_' . preg_replace('/[^A-Za-z0-9_-]+/', '_', $kelas['nama_kelas']) . '_' . date('Ymd_His') . '.xls';

        return $this->response
            ->setHeader('Content-Type', 'application/vnd.ms-excel; charset=utf-8')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $nama . '"')
            ->setHeader('Cache-Control', 'no-cache')
            ->setBody(view('master/kelas_excel', ['kelas' => $kelas, 'siswa' => $siswa, 'sekolah' => config('Sekolah')]));
    }
}
