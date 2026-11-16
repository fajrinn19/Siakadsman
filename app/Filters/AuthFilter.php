<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Wajib login untuk semua halaman aplikasi.
 */
class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->has('level')) {
            return redirect()->to(site_url('login'));
        }

        $uri = trim($request->getUri()->getPath(), '/');
        if (session('wajib_ganti_password') && ! in_array($uri, ['akun/password', 'logout'], true)) {
            return redirect()->to(site_url('akun/password'));
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }
}
