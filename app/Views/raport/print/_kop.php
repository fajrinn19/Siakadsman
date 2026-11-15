<?php /** Kop identitas siswa di atas halaman raport. */ ?>
<table width="100%">
    <tr><td width="140">Nama Sekolah</td><td>: <?= esc($iden['nama_sekolah'] ?? $sekolah->nama) ?></td><td width="140">Kelas</td><td>: <?= esc($kelas) ?></td></tr>
    <tr><td>Alamat</td><td>: <?= esc($iden['alamat_sekolah'] ?? '') ?></td><td>Semester</td><td>: <?= esc($semester) ?></td></tr>
    <tr><td>Nama Peserta Didik</td><td>: <b><?= esc($s['nama']) ?></b></td><td>Tahun Pelajaran</td><td>: <?= esc($t['keterangan']) ?></td></tr>
    <tr><td>No Induk / NISN</td><td>: <?= esc($s['nipd']) ?> / <?= esc($s['nisn']) ?></td><td></td><td></td></tr>
</table>
<br>
