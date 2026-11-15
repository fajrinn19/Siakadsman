<?php

namespace App\Models;

use CodeIgniter\Model;

class QuizUjianModel extends Model
{
    protected $table            = 'rb_quiz_ujian';
    protected $primaryKey       = 'id_quiz_ujian';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_kategori_quiz_ujian',
        'kodejdwl',
        'keterangan',
        'batas_waktu',
    ];

    /** Quiz beserta kategori dan kelasnya. */
    public function detail(int $id): ?array
    {
        return $this->select('rb_quiz_ujian.*, k.kategori_quiz_ujian, j.kode_kelas, kl.nama_kelas')
            ->join('rb_kategori_quiz_ujian k', 'rb_quiz_ujian.id_kategori_quiz_ujian = k.id_kategori_quiz_ujian', 'left')
            ->join('rb_jadwal_pelajaran j', 'rb_quiz_ujian.kodejdwl = j.kodejdwl', 'left')
            ->join('rb_kelas kl', 'j.kode_kelas = kl.kode_kelas', 'left')
            ->where('rb_quiz_ujian.id_quiz_ujian', $id)
            ->first();
    }

    public static function waktuHabis(array $quiz): bool
    {
        return tgl_valid($quiz['batas_waktu']) && strtotime($quiz['batas_waktu']) < time();
    }

    /**
     * Nilai siswa: objektif = 100 / jumlah soal x jawaban benar; akhir = (essai + objektif) / 2.
     *
     * @return array{objektif: float, essai: float, akhir: float, benar: int, total: int, essaiDinilai: bool}
     */
    public function nilai(int $id, string $nisn): array
    {
        $db    = $this->db;
        $total = $db->table('rb_pertanyaan_objektif')->where('id_quiz_ujian', $id)->countAllResults();
        $benar = $db->table('rb_jawaban_objektif a')
            ->join('rb_pertanyaan_objektif b', 'a.id_pertanyaan_objektif = b.id_pertanyaan_objektif')
            ->where('b.id_quiz_ujian', $id)->where('a.nisn', $nisn)
            ->where('LOWER(a.jawaban) = LOWER(b.kunci_jawaban)', null, false)
            ->countAllResults();
        $essai = $db->table('rb_nilai_pertanyaan_essai')->where(['id_quiz_ujian' => $id, 'nisn' => $nisn])->get()->getRowArray();

        $objektif = $total > 0 ? round(100 / $total * $benar, 2) : 0.0;
        $nEssai   = (float) ($essai['nilai_essai'] ?? 0);

        return [
            'objektif'     => $objektif,
            'essai'        => $nEssai,
            'akhir'        => round(($nEssai + $objektif) / 2, 2),
            'benar'        => $benar,
            'total'        => $total,
            'essaiDinilai' => $essai !== null,
        ];
    }
}
