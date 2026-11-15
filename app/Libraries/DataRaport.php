<?php

namespace App\Libraries;

use App\Models\IdentitasSekolahModel;
use App\Models\JadwalPelajaranModel;
use App\Models\KelompokMataPelajaranModel;
use App\Models\NilaiUtsModel;
use App\Models\PredikatModel;
use App\Models\TahunAkademikModel;

/**
 * Mengumpulkan data yang dibutuhkan halaman raport (layar siswa & cetak).
 */
class DataRaport
{
    /** Siswa beserta kelas dan wali kelasnya. */
    public static function siswa(string $nisn): ?array
    {
        return db_connect()->table('rb_siswa a')
            ->select('a.*, b.nama_kelas, b.nip AS nip_wali, c.nama_guru AS walikelas, jk.jenis_kelamin, ag.nama_agama')
            ->join('rb_kelas b', 'a.kode_kelas = b.kode_kelas', 'left')
            ->join('rb_guru c', 'b.nip = c.nip', 'left')
            ->join('rb_jenis_kelamin jk', 'a.id_jenis_kelamin = jk.id_jenis_kelamin', 'left')
            ->join('rb_agama ag', 'a.id_agama = ag.id_agama', 'left')
            ->where('a.nisn', $nisn)
            ->get()->getRowArray();
    }

    public static function tahun(string $id): ?array
    {
        return model(TahunAkademikModel::class)->find($id);
    }

    public static function identitas(): array
    {
        return model(IdentitasSekolahModel::class)->orderBy('id_identitas_sekolah', 'DESC')->first() ?? [];
    }

    /**
     * Mata pelajaran kelas pada tahun akademik, dikelompokkan per kelompok mapel,
     * lengkap dengan nilai raport siswa.
     *
     * @return list<array{kelompok: string, mapel: list<array<string, mixed>>}>
     */
    public static function nilaiRaport(string $nisn, string $kelas, string $tahun): array
    {
        $predikat = model(PredikatModel::class);

        return self::perKelompok($kelas, $tahun, static function (array $m) use ($nisn, $kelas, $predikat): array {
            $n = Raport::mapel($m['kodejdwl'], $nisn);

            return $m + [
                'pengetahuan'            => $n['pengetahuan']['raport'],
                'predikat_pengetahuan'   => $predikat->grade($n['pengetahuan']['raport'], $kelas),
                'deskripsi_pengetahuan'  => $n['pengetahuan']['deskripsi'],
                'keterampilan'           => $n['keterampilan']['raport'],
                'predikat_keterampilan'  => $predikat->grade($n['keterampilan']['raport'], $kelas),
                'deskripsi_keterampilan' => $n['keterampilan']['deskripsi'],
            ];
        });
    }

    /** @return list<array{kelompok: string, mapel: list<array<string, mixed>>}> */
    public static function nilaiUts(string $nisn, string $kelas, string $tahun): array
    {
        $predikat = model(PredikatModel::class);

        return self::perKelompok($kelas, $tahun, static function (array $m) use ($nisn, $kelas, $predikat): array {
            $n = model(NilaiUtsModel::class)->where(['kodejdwl' => $m['kodejdwl'], 'nisn' => $nisn])->first();

            return $m + [
                'pengetahuan'           => $n['angka_pengetahuan'] ?? null,
                'predikat_pengetahuan'  => $n ? $predikat->grade($n['angka_pengetahuan'], $kelas) : '',
                'keterampilan'          => $n['angka_keterampilan'] ?? null,
                'predikat_keterampilan' => $n ? $predikat->grade($n['angka_keterampilan'], $kelas) : '',
            ];
        });
    }

    /**
     * Jumlah ketidakhadiran siswa (S/I/A) pada semua jadwal kelas di tahun akademik itu.
     *
     * @return array{S: int, I: int, A: int}
     */
    public static function ketidakhadiran(string $nisn, string $kelas, string $tahun): array
    {
        $hasil = ['S' => 0, 'I' => 0, 'A' => 0];
        $rows  = db_connect()->table('rb_absensi_siswa a')
            ->select('a.kode_kehadiran, COUNT(*) AS total')
            ->join('rb_jadwal_pelajaran j', 'a.kodejdwl = j.kodejdwl')
            ->where(['a.nisn' => $nisn, 'j.kode_kelas' => $kelas, 'j.id_tahun_akademik' => $tahun])
            ->whereIn('a.kode_kehadiran', array_keys($hasil))
            ->groupBy('a.kode_kehadiran')
            ->get()->getResultArray();
        foreach ($rows as $r) {
            $hasil[$r['kode_kehadiran']] = (int) $r['total'];
        }

        return $hasil;
    }

    /**
     * @param callable(array): array $isi
     *
     * @return list<array{kelompok: string, mapel: list<array<string, mixed>>}>
     */
    private static function perKelompok(string $kelas, string $tahun, callable $isi): array
    {
        $jadwal = model(JadwalPelajaranModel::class)->lengkap()
            ->where(['rb_jadwal_pelajaran.kode_kelas' => $kelas, 'rb_jadwal_pelajaran.id_tahun_akademik' => $tahun])
            ->orderBy('m.urutan', 'ASC')->findAll();

        $hasil = [];
        foreach (model(KelompokMataPelajaranModel::class)->orderBy('id_kelompok_mata_pelajaran', 'ASC')->findAll() as $k) {
            $mapel = array_values(array_filter($jadwal, static fn ($j) => (int) $j['id_kelompok_mata_pelajaran'] === (int) $k['id_kelompok_mata_pelajaran']));
            $hasil[] = ['kelompok' => $k['nama_kelompok_mata_pelajaran'], 'mapel' => array_map($isi, $mapel)];
        }

        return $hasil;
    }
}
