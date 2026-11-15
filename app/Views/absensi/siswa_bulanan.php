<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$warna = ['H' => 'bg-green', 'S' => 'bg-yellow', 'I' => 'bg-aqua', 'A' => 'bg-red'];
$singkat = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
?>
<div class="col-md-12">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Rekap Absensi Bulan <?= nama_bulan($bulan) ?> <?= $tahun ?></h3>
            <form class="pull-right filter-form" method="get" action="<?= site_url('absensi-siswa/rekap/' . $jadwal['kodejdwl'] . '/bulanan') ?>">
                <select name="bulan"><?php for ($b = 1; $b <= 12; $b++): ?><option value="<?= $b ?>"<?= $b === $bulan ? ' selected' : '' ?>><?= nama_bulan($b) ?></option><?php endfor ?></select>
                <select name="tahun"><?php for ($t = (int) date('Y') - 3; $t <= (int) date('Y') + 1; $t++): ?><option<?= $t === $tahun ? ' selected' : '' ?>><?= $t ?></option><?php endfor ?></select>
                <button type="submit" class="btn btn-success btn-sm">Lihat</button>
                <button type="button" onclick="window.print()" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Cetak</button>
            </form>
        </div>
        <div class="box-body table-responsive">
            <?= view('components/info_jadwal', ['jadwal' => $jadwal]) ?>
            <table class="table table-bordered table-condensed" style="font-size:12px">
                <thead>
                <tr>
                    <th rowspan="2">No</th><th rowspan="2">NISN</th><th rowspan="2">Nama Siswa</th>
                    <th colspan="<?= $hari ?>" class="text-center">Tanggal</th>
                    <th rowspan="2">H</th><th rowspan="2">S</th><th rowspan="2">I</th><th rowspan="2">A</th>
                </tr>
                <tr>
                    <?php for ($d = 1; $d <= $hari; $d++): ?>
                        <?php $w = (int) date('w', mktime(0, 0, 0, $bulan, $d, $tahun)); ?>
                        <th class="text-center<?= $w === 0 ? ' bg-gray' : '' ?>"><?= $d ?><br><small><?= $singkat[$w] ?></small></th>
                    <?php endfor ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($siswa as $i => $s): ?>
                    <?php $jumlah = ['H' => 0, 'S' => 0, 'I' => 0, 'A' => 0]; ?>
                    <tr>
                        <td><?= $i + 1 ?></td><td><?= esc($s['nisn']) ?></td><td style="white-space:nowrap"><?= esc($s['nama']) ?></td>
                        <?php for ($d = 1; $d <= $hari; $d++): ?>
                            <?php $k = $absen[$s['nisn']][$d] ?? ''; if (isset($jumlah[$k])) { $jumlah[$k]++; } ?>
                            <td class="text-center <?= $warna[$k] ?? '' ?>"><?= $k !== '' ? esc($k) : '' ?></td>
                        <?php endfor ?>
                        <?php foreach ($jumlah as $n): ?><td class="text-center"><b><?= $n ?></b></td><?php endforeach ?>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
            <p><span class="badge bg-green">H</span> Hadir &nbsp; <span class="badge bg-yellow">S</span> Sakit &nbsp; <span class="badge bg-aqua">I</span> Izin &nbsp; <span class="badge bg-red">A</span> Alpa</p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
