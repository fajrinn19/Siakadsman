<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Tabel riwayat kelas siswa: mencatat setiap kali siswa masuk, naik, pindah, atau tinggal kelas.
 */
class BuatRiwayatKelas extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id_riwayat_kelas'  => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'nisn'              => ['type' => 'VARCHAR', 'constraint' => 20],
            'kode_kelas_asal'   => ['type' => 'VARCHAR', 'constraint' => 10, 'default' => ''],
            'kode_kelas_tujuan' => ['type' => 'VARCHAR', 'constraint' => 10, 'default' => ''],
            'angkatan_asal'     => ['type' => 'INT', 'constraint' => 5, 'default' => 0],
            'angkatan_tujuan'   => ['type' => 'INT', 'constraint' => 5, 'default' => 0],
            'id_tahun_akademik' => ['type' => 'VARCHAR', 'constraint' => 10, 'default' => ''],
            'jenis'             => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => ''],
            'keterangan'        => ['type' => 'TEXT', 'null' => true],
            'user_akses'        => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => ''],
            'waktu'             => ['type' => 'DATETIME'],
        ]);
        $this->forge->addKey('id_riwayat_kelas', true);
        $this->forge->addKey('nisn');
        $this->forge->createTable('rb_riwayat_kelas', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('rb_riwayat_kelas', true);
    }
}
