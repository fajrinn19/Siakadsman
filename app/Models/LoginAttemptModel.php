<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginAttemptModel extends Model
{
    protected $table            = 'login_attempts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'ip_address',
        'username',
        'attempt_time',
    ];

    /** Hapus catatan lama lalu hitung percobaan gagal dari IP ini dalam jendela blokir. */
    public function jumlahGagal(string $ip, int $menit): int
    {
        $batas = date('Y-m-d H:i:s', time() - $menit * 60);
        $this->where('attempt_time <', $batas)->delete();

        return $this->where('ip_address', $ip)->countAllResults();
    }

    /** Sisa detik blokir, dihitung dari percobaan gagal terakhir. */
    public function sisaDetikBlokir(string $ip, int $menit): int
    {
        $row = $this->where('ip_address', $ip)->orderBy('attempt_time', 'DESC')->first();
        if ($row === null) {
            return 0;
        }

        return max(0, strtotime($row['attempt_time']) + $menit * 60 - time());
    }

    public function catat(string $ip, string $username): void
    {
        $this->insert(['ip_address' => $ip, 'username' => mb_substr($username, 0, 100), 'attempt_time' => date('Y-m-d H:i:s')]);
    }

    public function bersihkan(string $ip): void
    {
        $this->where('ip_address', $ip)->delete();
    }
}
