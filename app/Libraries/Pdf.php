<?php

namespace App\Libraries;

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Gabungkan beberapa halaman cetak (HTML dari view layouts/cetak) menjadi satu PDF.
 */
class Pdf
{
    /** @param list<string> $halaman HTML lengkap per halaman */
    public static function dariHalaman(array $halaman, string $ukuran = 'A4'): string
    {
        $css = (string) @file_get_contents(FCPATH . 'bootstrap/css/printer.css');
        $isi = [];
        foreach ($halaman as $html) {
            // Ambil isi <body> dan <style> tambahan; gambar dibaca dari disk, bukan lewat HTTP.
            preg_match_all('#<style[^>]*>(.*?)</style>#is', $html, $style);
            $css  .= "\n" . implode("\n", $style[1]);
            $body  = preg_match('#<body[^>]*>(.*)</body>#is', $html, $m) ? $m[1] : $html;
            $isi[] = str_replace(rtrim(base_url(), '/') . '/', FCPATH, $body);
        }

        $doc = '<!DOCTYPE html><html><head><meta charset="utf-8"><style>' . $css . '
            body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 11px; }
            .halaman { page-break-after: always; } .halaman:last-child { page-break-after: auto; }
            table.garis { border-collapse: collapse; } table.garis th, table.garis td { border: 1px solid #000; padding: 3px; }
            h1 { font-size: 20px; } h2 { font-size: 16px; } h3 { font-size: 14px; }
        </style></head><body><div class="halaman">' . implode('</div><div class="halaman">', $isi) . '</div></body></html>';

        $opsi = new Options();
        $opsi->set('chroot', FCPATH);
        $opsi->set('isRemoteEnabled', false);
        $opsi->set('defaultFont', 'DejaVu Sans');

        $pdf = new Dompdf($opsi);
        $pdf->loadHtml($doc, 'UTF-8');
        $pdf->setPaper($ukuran, 'portrait');
        $pdf->render();

        return (string) $pdf->output();
    }
}
