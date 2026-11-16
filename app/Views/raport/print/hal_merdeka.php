<?= $this->extend('layouts/cetak') ?>
<?= $this->section('content') ?>
<?php
// Format Kurikulum Merdeka: satu nilai akhir per mapel + deskripsi capaian kompetensi.
$nilaiAkhir = static function (array $m): ?float {
    $ada = array_filter([$m['pengetahuan'], $m['keterampilan']], static fn ($v) => $v !== null);

    return $ada === [] ? null : array_sum($ada) / count($ada);
};
?>
<h3 style="text-align:center; margin-top:0">LAPORAN HASIL BELAJAR<br><small>(Kurikulum Merdeka)</small></h3>
<?= view('raport/print/_kop', $this->data) ?>
<table width="100%" border="1" class="garis">
    <tr><th width="30">No</th><th width="200">Mata Pelajaran</th><th width="60">Nilai Akhir</th><th>Capaian Kompetensi</th></tr>
    <?php foreach ($kelompok as $k): ?>
        <tr><td colspan="4"><b><?= esc($k['kelompok']) ?></b></td></tr>
        <?php foreach ($k['mapel'] as $i => $m): ?>
            <tr>
                <td align="center"><?= $i + 1 ?></td>
                <td><?= esc($m['namamatapelajaran']) ?></td>
                <td align="center"><?= nilai_angka($nilaiAkhir($m)) ?></td>
                <td><?= esc(trim($m['deskripsi_pengetahuan'] . ' ' . $m['deskripsi_keterampilan'])) ?></td>
            </tr>
        <?php endforeach ?>
    <?php endforeach ?>
</table>
<br>
<table width="100%" border="1" class="garis">
    <tr><th width="30">No</th><th width="200">Ekstrakurikuler</th><th>Keterangan</th></tr>
    <?php foreach ($ekstra as $i => $e): ?>
        <tr><td align="center"><?= $i + 1 ?></td><td><?= esc($e['kegiatan']) ?></td><td><?= esc($e['deskripsi']) ?></td></tr>
    <?php endforeach ?>
    <?php if ($ekstra === []): ?><tr><td colspan="3">&nbsp;</td></tr><?php endif ?>
</table>
<br>
<table width="100%"><tr>
    <td width="45%" valign="top">
        <table width="100%" border="1" class="garis">
            <tr><th colspan="2">Ketidakhadiran</th></tr>
            <tr><td>Sakit</td><td align="center"><?= $absen['S'] ?> hari</td></tr>
            <tr><td>Izin</td><td align="center"><?= $absen['I'] ?> hari</td></tr>
            <tr><td>Tanpa Keterangan</td><td align="center"><?= $absen['A'] ?> hari</td></tr>
        </table>
    </td>
    <td width="55%" valign="top">
        <table width="100%" border="1" class="garis">
            <tr><th>Catatan Wali Kelas</th></tr>
            <tr><td style="height:60px"><?= esc(trim(($sikap['spiritual_deskripsi'] ?? '') . ' ' . ($sikap['sosial_deskripsi'] ?? ''))) ?></td></tr>
        </table>
    </td>
</tr></table>
<?= view('raport/_ttd', ['sekolah' => $sekolah, 'wali' => $wali]) ?>
<?= $this->endSection() ?>
