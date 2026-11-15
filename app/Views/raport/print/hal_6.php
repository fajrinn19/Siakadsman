<?= $this->extend('layouts/cetak') ?>
<?= $this->section('content') ?>
<?= view('raport/print/_kop', $this->data) ?>
<b>C. Ekstrakurikuler</b>
<table width="100%" border="1" class="garis">
    <tr><th width="40">No</th><th width="30%">Kegiatan Ekstrakurikuler</th><th>Nilai</th><th>Deskripsi</th></tr>
    <?php foreach ($ekstra as $i => $e): ?>
        <tr><td><?= $i + 1 ?></td><td><?= esc($e['kegiatan']) ?></td><td><?= esc((string) $e['nilai']) ?></td><td><?= esc($e['deskripsi']) ?></td></tr>
    <?php endforeach ?>
    <?php if ($ekstra === []): ?><tr><td colspan="4">&nbsp;</td></tr><?php endif ?>
</table><br>
<b>D. Prestasi</b>
<table width="100%" border="1" class="garis">
    <tr><th width="40">No</th><th width="30%">Jenis Kegiatan</th><th>Keterangan</th></tr>
    <?php foreach ($prestasi as $i => $p): ?>
        <tr><td><?= $i + 1 ?></td><td><?= esc($p['jenis_kegiatan']) ?></td><td><?= esc($p['keterangan']) ?></td></tr>
    <?php endforeach ?>
    <?php if ($prestasi === []): ?><tr><td colspan="3">&nbsp;</td></tr><?php endif ?>
</table><br>
<b>E. Ketidakhadiran</b>
<table width="85%" border="1" class="garis">
    <tr><td width="70%">Sakit</td><td width="10">:</td><td align="center"><?= $absen['S'] ?> kali</td></tr>
    <tr><td>Izin</td><td>:</td><td align="center"><?= $absen['I'] ?> kali</td></tr>
    <tr><td>Tanpa Keterangan</td><td>:</td><td align="center"><?= $absen['A'] ?> kali</td></tr>
</table><br>
<b>F. Catatan Wali Kelas</b>
<table width="100%" height="80" border="1" class="garis"><tr><td></td></tr></table><br>
<b>G. Tanggapan Orang Tua / Wali</b>
<table width="100%" height="80" border="1" class="garis"><tr><td></td></tr></table>
<?= view('raport/_ttd', ['sekolah' => $sekolah, 'wali' => $wali]) ?>
<?= $this->endSection() ?>
