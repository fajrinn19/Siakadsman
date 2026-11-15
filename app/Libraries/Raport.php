<?php

namespace App\Libraries;

use App\Models\NilaiKeterampilanModel;
use App\Models\NilaiPengetahuanModel;

/**
 * Rumus nilai raport (sama dengan aplikasi lama):
 *
 * - Pengetahuan: nilai per KD = rata-rata nilai1..nilai5; nilai raport = rata-rata nilai per KD.
 * - Keterampilan: nilai per KD = nilai tertinggi dari nilai1..nilai6; nilai raport = rata-rata nilai per KD.
 * - Deskripsi raport diambil dari KD dengan nilai tertinggi.
 */
class Raport
{
    /** @var array<string, array{model: class-string, pk: string, kolom: list<string>, judul: string, header: list<string>, rumus: string}> */
    public const JENIS = [
        'pengetahuan' => [
            'model'  => NilaiPengetahuanModel::class,
            'pk'     => 'id_nilai_pengetahuan',
            'kolom'  => ['nilai1', 'nilai2', 'nilai3', 'nilai4', 'nilai5'],
            'judul'  => 'Pengetahuan',
            'header' => ['UH', 'UTS', 'TU', 'SM', 'Lain'],
            'rumus'  => 'rata',
        ],
        'keterampilan' => [
            'model'  => NilaiKeterampilanModel::class,
            'pk'     => 'id_nilai_keterampilan',
            'kolom'  => ['nilai1', 'nilai2', 'nilai3', 'nilai4', 'nilai5', 'nilai6'],
            'judul'  => 'Keterampilan',
            'header' => ['Praktek 1', 'Praktek 2', 'Proyek 1', 'Proyek 2', 'Portofolio 1', 'Portofolio 2'],
            'rumus'  => 'maks',
        ],
    ];

    /** Nilai satu baris KD. */
    public static function nilaiKd(string $jenis, array $row): float
    {
        $nilai = array_map(static fn ($k) => (float) $row[$k], self::JENIS[$jenis]['kolom']);

        return self::JENIS[$jenis]['rumus'] === 'maks' ? max($nilai) : array_sum($nilai) / count($nilai);
    }

    /**
     * Semua nilai KD siswa per jadwal, dikelompokkan per NISN.
     *
     * @param list<string>|null $nisn batasi ke NISN tertentu
     *
     * @return array<string, list<array<string, mixed>>>
     */
    public static function entri(string $jenis, int|string $kodejdwl, ?array $nisn = null): array
    {
        $b = model(self::JENIS[$jenis]['model'])->where('kodejdwl', $kodejdwl);
        if ($nisn !== null) {
            if ($nisn === []) {
                return [];
            }
            $b->whereIn('nisn', $nisn);
        }

        $hasil = [];
        foreach ($b->orderBy(self::JENIS[$jenis]['pk'], 'ASC')->findAll() as $r) {
            $r['nilai_kd']         = self::nilaiKd($jenis, $r);
            $hasil[$r['nisn']][] = $r;
        }

        return $hasil;
    }

    /**
     * Ringkasan nilai raport dari daftar entri KD seorang siswa.
     *
     * @param list<array<string, mixed>> $entri
     *
     * @return array{raport: float|null, tertinggi: float|null, deskripsi: string}
     */
    public static function ringkas(array $entri): array
    {
        if ($entri === []) {
            return ['raport' => null, 'tertinggi' => null, 'deskripsi' => ''];
        }
        $terbaik = $entri[0];
        foreach ($entri as $e) {
            if ($e['nilai_kd'] > $terbaik['nilai_kd']) {
                $terbaik = $e;
            }
        }

        return [
            'raport'    => array_sum(array_column($entri, 'nilai_kd')) / count($entri),
            'tertinggi' => $terbaik['nilai_kd'],
            'deskripsi' => (string) $terbaik['deskripsi'],
        ];
    }

    /**
     * Ringkasan nilai pengetahuan & keterampilan satu siswa untuk satu jadwal.
     *
     * @return array{pengetahuan: array, keterampilan: array}
     */
    public static function mapel(int|string $kodejdwl, string $nisn): array
    {
        return [
            'pengetahuan'  => self::ringkas(self::entri('pengetahuan', $kodejdwl, [$nisn])[$nisn] ?? []),
            'keterampilan' => self::ringkas(self::entri('keterampilan', $kodejdwl, [$nisn])[$nisn] ?? []),
        ];
    }
}
