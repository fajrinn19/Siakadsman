<?php
/**
 * Riwayat kelas siswa (terbaru di atas).
 *
 * @var array       $s
 * @var list<array> $riwayat
 */
$warna = ['Masuk' => 'chip-aktif', 'Naik Kelas' => 'chip-aktif', 'Pindah Kelas' => 'chip-tunggu', 'Tinggal Kelas' => 'chip-tunggu', 'Lulus' => 'chip-aktif', 'Perubahan Data' => 'chip-redup'];
$label = static fn ($kode, $nama) => $kode === '' ? '-' : esc($kode) . ($nama ? ' <small class="text-muted">' . esc($nama) . '</small>' : '');
?>
<p>Kelas saat ini: <b><?= esc($s['kode_kelas']) ?></b> <?= $s['nama_kelas'] ? '(' . esc($s['nama_kelas']) . ')' : '' ?>, angkatan <b><?= esc((string) $s['angkatan']) ?></b></p>
<?php if ($riwayat === []): ?>
    <div class="text-muted" style="padding:20px 0">
        Belum ada riwayat kelas tercatat. Riwayat mulai dicatat otomatis saat siswa ditambahkan, dinaikkan, atau dipindahkan kelas.
    </div>
<?php else: ?>
    <table class="table table-hover table-condensed">
        <thead><tr><th style="width:30px">No</th><th>Tanggal</th><th>Tahun Akademik</th><th>Dari Kelas</th><th>Ke Kelas</th><th>Angkatan</th><th>Jenis</th><th>Keterangan</th><?php if (level() === 'superuser'): ?><th></th><?php endif ?></tr></thead>
        <tbody>
        <?php foreach ($riwayat as $i => $r): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td style="white-space:nowrap"><?= tgl_indo($r['waktu']) ?></td>
                <td><?= esc($r['nama_tahun'] ?? $r['id_tahun_akademik'] ?: '-') ?></td>
                <td><?= $label($r['kode_kelas_asal'], $r['nama_kelas_asal']) ?></td>
                <td><?= $label($r['kode_kelas_tujuan'], $r['nama_kelas_tujuan']) ?></td>
                <td><?= (int) $r['angkatan_asal'] !== (int) $r['angkatan_tujuan'] && (int) $r['angkatan_asal'] > 0 ? (int) $r['angkatan_asal'] . ' &rarr; ' : '' ?><?= (int) $r['angkatan_tujuan'] ?: '-' ?></td>
                <td><span class="chip <?= $warna[$r['jenis']] ?? 'chip-redup' ?>"><?= esc($r['jenis']) ?></span></td>
                <td><?= esc((string) $r['keterangan']) ?><?= ! empty($r['nama_pencatat']) ? '<br><small class="text-muted">oleh ' . esc($r['nama_pencatat']) . '</small>' : '' ?></td>
                <?php if (level() === 'superuser'): ?>
                    <td><?= tombol_hapus(site_url('siswa/riwayat/hapus/' . $r['id_riwayat_kelas']), 'Hapus catatan riwayat ini?') ?></td>
                <?php endif ?>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
<?php endif ?>
