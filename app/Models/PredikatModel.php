<?php

namespace App\Models;

use CodeIgniter\Model;

class PredikatModel extends Model
{
    protected $table            = 'rb_predikat';
    protected $primaryKey       = 'id_predikat';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'kode_kelas',
        'nilai_a',
        'nilai_b',
        'grade',
        'keterangan',
    ];

    /** @var array<string, list<array<string, mixed>>> */
    private array $cache = [];

    /**
     * Daftar predikat untuk kelas; jika kelas tidak punya aturan sendiri, pakai aturan umum (kode_kelas = '0').
     *
     * @return list<array<string, mixed>>
     */
    public function untukKelas(string $kodeKelas): array
    {
        if (! isset($this->cache[$kodeKelas])) {
            $rows = $this->where('kode_kelas', $kodeKelas)->orderBy('nilai_a', 'DESC')->findAll();
            if ($rows === []) {
                $rows = $this->where('kode_kelas', '0')->orderBy('nilai_a', 'DESC')->findAll();
            }
            $this->cache[$kodeKelas] = $rows;
        }

        return $this->cache[$kodeKelas];
    }

    /** Huruf predikat untuk sebuah nilai (dibulatkan), atau '' jika nilai kosong / di luar rentang. */
    public function grade(float|int|string|null $nilai, string $kodeKelas): string
    {
        if ($nilai === null || $nilai === '') {
            return '';
        }
        $n = round((float) $nilai);
        foreach ($this->untukKelas($kodeKelas) as $p) {
            if ($n >= (float) $p['nilai_a'] && $n <= (float) $p['nilai_b']) {
                return (string) $p['grade'];
            }
        }

        return '';
    }
}
