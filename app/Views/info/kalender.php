<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $warna = ['Libur' => 'chip-tunggu', 'Ujian' => 'chip-aktif', 'Pembagian Raport' => 'chip-aktif']; ?>
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><i class="fa fa-calendar"></i> Kalender Akademik <?= $tahun ?></h3>
            <div class="pull-right">
                <a class="btn btn-default btn-sm" href="?tahun=<?= $tahun - 1 ?>"><i class="fa fa-chevron-left"></i> <?= $tahun - 1 ?></a>
                <a class="btn btn-default btn-sm" href="?tahun=<?= $tahun + 1 ?>"><?= $tahun + 1 ?> <i class="fa fa-chevron-right"></i></a>
                <?php if (level() === 'superuser'): ?><a class="btn btn-primary btn-sm" href="<?= site_url('kalender') ?>"><i class="fa fa-pencil"></i> Kelola</a><?php endif ?>
            </div>
        </div>
        <div class="box-body">
            <?php if ($perBulan === []): ?><div class="pesan-kosong">Belum ada agenda pada tahun <?= $tahun ?>.</div><?php endif ?>
            <div class="row">
                <?php foreach ($perBulan as $bulan => $agenda): ?>
                    <div class="col-md-4 col-sm-6">
                        <h4 style="font-weight:600; color:var(--utama)"><?= nama_bulan($bulan) ?></h4>
                        <table class="table table-condensed">
                            <?php foreach ($agenda as $a): ?>
                                <tr>
                                    <td style="width:80px; white-space:nowrap"><b><?= (int) substr($a['tanggal_mulai'], 8, 2) ?><?= $a['tanggal_selesai'] !== $a['tanggal_mulai'] ? '–' . tgl_indo($a['tanggal_selesai']) : '' ?></b></td>
                                    <td><?= esc($a['judul']) ?> <span class="chip <?= $warna[$a['jenis']] ?? 'chip-redup' ?>"><?= esc($a['jenis']) ?></span>
                                        <?php if ($a['keterangan']): ?><br><small class="text-muted"><?= esc($a['keterangan']) ?></small><?php endif ?></td>
                                </tr>
                            <?php endforeach ?>
                        </table>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
