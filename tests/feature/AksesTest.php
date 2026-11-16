<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * Uji akses halaman per level pengguna (butuh database MySQL/MariaDB berisi database/siakad-st.sql).
 *
 * @internal
 */
final class AksesTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    protected function setUp(): void
    {
        parent::setUp();
        try {
            db_connect()->query('SELECT 1 FROM rb_users LIMIT 1');
        } catch (\Throwable $e) {
            $this->markTestSkipped('Database uji tidak tersedia: ' . $e->getMessage());
        }
    }

    private function sebagai(string $level, string $id, array $tambahan = []): self
    {
        return $this->withSession(['level' => $level, 'id' => $id, 'namalengkap' => 'Penguji'] + $tambahan);
    }

    public function testHalamanLoginDanPpdbPublik(): void
    {
        $login = $this->get('login');
        $login->assertOK();
        $login->assertSee('Selamat datang');

        $ppdb = $this->get('ppdb');
        $ppdb->assertOK();
        $ppdb->assertSee('Kirim Pendaftaran');
    }

    public function testTanpaLoginDiarahkanKeLogin(): void
    {
        $this->get('/')->assertRedirectTo(site_url('login'));
        $this->get('siswa')->assertRedirectTo(site_url('login'));
    }

    public function testAdminBisaMembukaDataMaster(): void
    {
        foreach (['/', 'gedung', 'kelas', 'mata-pelajaran', 'tahun-akademik', 'pemeriksaan-data', 'kenaikan-kelas', 'ppdb/admin', 'log-aktivitas'] as $url) {
            $this->sebagai('superuser', '1')->get($url)->assertOK();
        }
    }

    public function testSiswaTidakBisaMembukaHalamanAdmin(): void
    {
        $siswa = db_connect()->table('rb_siswa')->get(1)->getRowArray();
        $sesi  = ['kode_kelas' => $siswa['kode_kelas'], 'angkatan' => $siswa['angkatan']];

        $this->sebagai('siswa', $siswa['nisn'], $sesi)->get('/')->assertOK();
        $this->sebagai('siswa', $siswa['nisn'], $sesi)->get('gedung')->assertRedirectTo(site_url('/'));
        $this->sebagai('siswa', $siswa['nisn'], $sesi)->get('log-aktivitas')->assertRedirectTo(site_url('/'));
    }

    public function testWajibGantiPassword(): void
    {
        $this->sebagai('superuser', '1', ['wajib_ganti_password' => true])->get('gedung')->assertRedirectTo(site_url('akun/password'));
    }

    public function testKepalaSekolahHanyaBaca(): void
    {
        $hasil = $this->sebagai('kepala', '2')->get('gedung');
        $hasil->assertOK();
        $hasil->assertDontSee('Tambah Data');
        $this->expectException(\CodeIgniter\Exceptions\PageNotFoundException::class);
        $this->sebagai('kepala', '2')->get('gedung/tambah');
    }
}
