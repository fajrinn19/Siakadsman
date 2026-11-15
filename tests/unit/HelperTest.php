<?php

use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class HelperTest extends CIUnitTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        helper('siakad');
    }

    public function testFormatTanggal(): void
    {
        $this->assertSame('05 Mar 2024', tgl_indo('2024-03-05'));
        $this->assertSame('05 Maret 2024', tgl_raport('2024-03-05'));
        $this->assertSame('05-03-2024', tgl_view('2024-03-05'));
        $this->assertSame('2024-03-05', tgl_simpan('05-03-2024'));
    }

    public function testTanggalKosongAman(): void
    {
        $this->assertSame('-', tgl_indo('0000-00-00'));
        $this->assertSame('-', tgl_indo(null));
        $this->assertSame('', tgl_view('0000-00-00'));
    }

    public function testSemesterDariKodeTahun(): void
    {
        $this->assertSame('Ganjil', semester_dari_tahun('20231'));
        $this->assertSame('Genap', semester_dari_tahun('20232'));
    }

    public function testHariIni(): void
    {
        $this->assertSame('Senin', hari_ini('2024-03-04'));
    }
}
