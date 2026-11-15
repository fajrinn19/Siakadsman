<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Batasi rute berdasarkan level pengguna, contoh: 'role:superuser,kepala'.
 */
class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $level = (string) session('level');

        if ($level === '') {
            return redirect()->to(site_url('login'));
        }

        if ($arguments !== null && ! in_array($level, $arguments, true)) {
            return redirect()->to(site_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }
}
