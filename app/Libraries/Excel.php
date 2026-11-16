<?php

namespace App\Libraries;

use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/** Bantuan membuat & membaca file Excel (PhpSpreadsheet). */
class Excel
{
    /**
     * Buat workbook satu sheet dari judul kolom + baris data.
     *
     * @param list<string>       $header
     * @param list<list<mixed>>  $baris
     * @param list<string>       $judul  baris judul di atas tabel (opsional)
     */
    public static function buat(string $namaSheet, array $header, array $baris, array $judul = []): Spreadsheet
    {
        $book  = new Spreadsheet();
        $sheet = $book->getActiveSheet()->setTitle(mb_substr($namaSheet, 0, 31));
        $r     = 1;
        foreach ($judul as $j) {
            $sheet->setCellValue([1, $r++], $j);
        }
        if ($judul !== []) {
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(13);
            $r++;
        }

        $awalHeader = $r;
        foreach ($header as $c => $h) {
            $sheet->setCellValue([$c + 1, $r], $h);
        }
        $kolomAkhir = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(max(1, count($header)));
        $sheet->getStyle("A{$r}:{$kolomAkhir}{$r}")->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle("A{$r}:{$kolomAkhir}{$r}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('0F6B5C');

        foreach ($baris as $b) {
            $r++;
            foreach (array_values($b) as $c => $v) {
                // Simpan angka panjang (NISN, NIP, no HP) sebagai teks agar nol di depan tidak hilang.
                if (is_string($v) && preg_match('/^0\d+$|^\d{11,}$/', $v)) {
                    $sheet->setCellValueExplicit([$c + 1, $r], $v, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                } else {
                    $sheet->setCellValue([$c + 1, $r], $v);
                }
            }
        }
        foreach (range(1, count($header)) as $c) {
            $sheet->getColumnDimensionByColumn($c)->setAutoSize(true);
        }
        $sheet->freezePane('A' . ($awalHeader + 1));

        return $book;
    }

    public static function unduh(Spreadsheet $book, string $namaFile): ResponseInterface
    {
        ob_start();
        (new Xlsx($book))->save('php://output');
        $isi = (string) ob_get_clean();

        return service('response')
            ->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->setHeader('Content-Disposition', 'attachment; filename="' . preg_replace('/[^A-Za-z0-9._-]+/', '_', $namaFile) . '"')
            ->setHeader('Cache-Control', 'no-cache')
            ->setBody($isi);
    }

    /**
     * Baca sheet pertama menjadi array asosiatif berdasarkan baris header (huruf kecil).
     *
     * @return list<array<string, string>>
     */
    public static function baca(string $path): array
    {
        $rows   = IOFactory::load($path)->getActiveSheet()->toArray(null, true, true, false);
        $header = array_map(static fn ($h) => strtolower(trim((string) $h)), array_shift($rows) ?? []);
        $hasil  = [];
        foreach ($rows as $row) {
            if (implode('', array_map('strval', $row)) === '') {
                continue;
            }
            $data = [];
            foreach ($header as $i => $h) {
                if ($h !== '') {
                    $data[$h] = trim((string) ($row[$i] ?? ''));
                }
            }
            $hasil[] = $data;
        }

        return $hasil;
    }
}
