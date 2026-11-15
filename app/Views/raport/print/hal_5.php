<?= $this->extend('layouts/cetak') ?>
<?= $this->section('content') ?>
<?= view('raport/print/_kop', $this->data) ?>
<b>DESKRIPSI PENGETAHUAN DAN KETERAMPILAN</b>
<table width="100%" border="1" class="garis" style="margin-top:2px">
    <tr><th colspan="2">Mata Pelajaran</th><th width="140">Aspek</th><th>Deskripsi</th></tr>
    <?php foreach ($kelompok as $k): ?>
        <tr><td colspan="4"><b><?= esc($k['kelompok']) ?></b></td></tr>
        <?php foreach ($k['mapel'] as $i => $m): ?>
            <tr><td width="30" rowspan="2" align="center"><?= $i + 1 ?></td><td width="180" rowspan="2"><?= esc($m['namamatapelajaran']) ?></td>
                <td>Pengetahuan</td><td><?= esc($m['deskripsi_pengetahuan']) ?></td></tr>
            <tr><td>Keterampilan</td><td><?= esc($m['deskripsi_keterampilan']) ?></td></tr>
        <?php endforeach ?>
    <?php endforeach ?>
</table>
<?= $this->endSection() ?>
