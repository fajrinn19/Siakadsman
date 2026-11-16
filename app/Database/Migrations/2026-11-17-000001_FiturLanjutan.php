<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Tabel untuk portal orang tua, pengumuman, kalender akademik, dan log aktivitas.
 */
class FiturLanjutan extends Migration
{
    public function up(): void
    {
        // Akun orang tua / wali (satu akun per siswa).
        $this->forge->addField([
            'id_ortu'    => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'nisn'       => ['type' => 'VARCHAR', 'constraint' => 20],
            'username'   => ['type' => 'VARCHAR', 'constraint' => 50],
            'password'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'nama'       => ['type' => 'VARCHAR', 'constraint' => 150, 'default' => ''],
            'no_hp'      => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => ''],
            'aktif'      => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Ya'],
            'waktu'      => ['type' => 'DATETIME'],
        ]);
        $this->forge->addKey('id_ortu', true);
        $this->forge->addUniqueKey('username');
        $this->forge->addKey('nisn');
        $this->forge->createTable('rb_ortu', true);

        $this->forge->addField([
            'id_pengumuman'   => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'judul'           => ['type' => 'VARCHAR', 'constraint' => 200],
            'isi'             => ['type' => 'TEXT'],
            'untuk'           => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'semua'],
            'tanggal_mulai'   => ['type' => 'DATE'],
            'tanggal_selesai' => ['type' => 'DATE'],
            'user_akses'      => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => ''],
            'waktu'           => ['type' => 'DATETIME'],
        ]);
        $this->forge->addKey('id_pengumuman', true);
        $this->forge->createTable('rb_pengumuman', true);

        $this->forge->addField([
            'id_kalender'     => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'judul'           => ['type' => 'VARCHAR', 'constraint' => 200],
            'jenis'           => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'Kegiatan'],
            'tanggal_mulai'   => ['type' => 'DATE'],
            'tanggal_selesai' => ['type' => 'DATE'],
            'keterangan'      => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addKey('id_kalender', true);
        $this->forge->addKey('tanggal_mulai');
        $this->forge->createTable('rb_kalender', true);

        $this->forge->addField([
            'id_log'  => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'id_user' => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => ''],
            'nama'    => ['type' => 'VARCHAR', 'constraint' => 150, 'default' => ''],
            'level'   => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => ''],
            'aksi'    => ['type' => 'VARCHAR', 'constraint' => 255],
            'url'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'ip'      => ['type' => 'VARCHAR', 'constraint' => 45, 'default' => ''],
            'waktu'   => ['type' => 'DATETIME'],
        ]);
        $this->forge->addKey('id_log', true);
        $this->forge->addKey('waktu');
        $this->forge->createTable('rb_log_aktivitas', true);
    }

    public function down(): void
    {
        foreach (['rb_log_aktivitas', 'rb_kalender', 'rb_pengumuman', 'rb_ortu'] as $t) {
            $this->forge->dropTable($t, true);
        }
    }
}
