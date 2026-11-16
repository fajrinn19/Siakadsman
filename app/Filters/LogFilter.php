<?php

namespace App\Filters;

use App\Models\LogAktivitasModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Catat setiap aksi tulis (POST) pengguna yang sudah login ke rb_log_aktivitas.
 */
class LogFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        if (strtoupper($request->getMethod()) !== 'POST' || ! session()->has('level') || $response->getStatusCode() >= 400) {
            return null;
        }

        $path = trim($request->getUri()->getPath(), '/');
        $aksi = match (true) {
            str_contains($path, '/hapus') || str_contains($path, 'hapus/') => 'Menghapus data',
            str_contains($path, '/tambah')                               => 'Menambah data',
            str_contains($path, '/edit')                                 => 'Mengubah data',
            str_contains($path, 'password')                              => 'Mengganti password',
            default                                                      => 'Menyimpan data',
        };
        $modul = ucwords(str_replace(['-', '/'], [' ', ' › '], preg_replace('#/(tambah|edit|hapus).*$#', '', $path)));

        try {
            model(LogAktivitasModel::class)->insert([
                'id_user' => (string) session('id'),
                'nama'    => mb_substr((string) session('namalengkap'), 0, 150),
                'level'   => (string) session('level'),
                'aksi'    => mb_substr($aksi . ($modul !== '' ? ': ' . $modul : ''), 0, 255),
                'url'     => mb_substr($path, 0, 255),
                'ip'      => $request->getIPAddress(),
                'waktu'   => date('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable) {
            // Log tidak boleh menggagalkan aksi utama (mis. tabel belum dimigrasi).
        }

        return null;
    }
}
