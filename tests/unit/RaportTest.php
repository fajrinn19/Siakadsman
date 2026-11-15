<?php

use App\Libraries\Raport;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class RaportTest extends CIUnitTestCase
{
    public function testPengetahuanMemakaiRataRata(): void
    {
        $row = ['nilai1' => 80, 'nilai2' => 90, 'nilai3' => 70, 'nilai4' => 85, 'nilai5' => 75];

        $this->assertEqualsWithDelta(80.0, Raport::nilaiKd('pengetahuan', $row), 0.001);
    }

    public function testKeterampilanMemakaiNilaiTertinggi(): void
    {
        $row = ['nilai1' => 70, 'nilai2' => 88, 'nilai3' => 60, 'nilai4' => 0, 'nilai5' => 0, 'nilai6' => 0];

        $this->assertEqualsWithDelta(88.0, Raport::nilaiKd('keterampilan', $row), 0.001);
    }

    public function testRingkasanRaport(): void
    {
        $r = Raport::ringkas([
            ['nilai_kd' => 80.0, 'deskripsi' => 'KD 3.1'],
            ['nilai_kd' => 90.0, 'deskripsi' => 'KD 3.2'],
        ]);

        $this->assertEqualsWithDelta(85.0, $r['raport'], 0.001);
        $this->assertEqualsWithDelta(90.0, $r['tertinggi'], 0.001);
        $this->assertSame('KD 3.2', $r['deskripsi']);
    }

    public function testRingkasanKosong(): void
    {
        $this->assertSame(['raport' => null, 'tertinggi' => null, 'deskripsi' => ''], Raport::ringkas([]));
    }
}
