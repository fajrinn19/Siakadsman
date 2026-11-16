<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Ubah tabel MyISAM ke InnoDB (mendukung transaksi & lebih tahan crash).
 * Isi data tidak diubah. Foreign key belum ditambahkan karena data lama masih punya baris yatim;
 * rapikan dulu lewat menu "Pemeriksaan Data".
 */
class UbahKeInnoDB extends Migration
{
    public function up(): void
    {
        $db = $this->db;
        foreach ($db->query("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND ENGINE = 'MyISAM'")->getResultArray() as $t) {
            $db->query('ALTER TABLE ' . $db->escapeIdentifiers($t['TABLE_NAME']) . ' ENGINE = InnoDB');
        }
    }

    public function down(): void
    {
        // Tidak dikembalikan ke MyISAM.
    }
}
