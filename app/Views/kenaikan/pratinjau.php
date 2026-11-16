<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $total = array_sum(array_map(static fn ($g) => count($g['siswa']), $grup)); ?>
<div class="col-xs-12">
    <form method="post" action="<?= site_url('kenaikan-kelas/proses') ?>" onsubmit="return confirm('Proses kenaikan kelas untuk <?= $total ?> siswa? Tindakan ini mengubah kelas/status siswa.')">
        <?= csrf_field() ?>
        <?= form_hidden(['tahun' => $tahun, 'keterangan' => $keterangan]) ?>
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-list-alt"></i> Langkah 2 — Pratinjau (<?= $total ?> siswa)</h3>
                <a class="btn btn-default btn-sm pull-right" href="<?= site_url('kenaikan-kelas') ?>"><i class="fa fa-arrow-left"></i> Ubah Pemetaan</a>
            </div>
            <div class="box-body">
                <p class="text-muted">Hapus centang siswa yang <b>tinggal kelas</b>; mereka tetap di kelas asal dan dicatat "Tinggal Kelas".</p>
                <div class="row">
                    <?php foreach ($grup as $g): ?>
                        <?= form_hidden('peta[' . $g['asal'] . ']', $g['tujuan']) ?>
                        <div class="col-md-6">
                            <h4 style="font-weight:600"><?= esc($g['asal']) ?> &rarr; <?= $g['tujuan'] === $lulus ? '<span class="text-green">Lulus</span>' : esc($g['tujuan']) ?>
                                <small>(<?= count($g['siswa']) ?> siswa)</small></h4>
                            <table class="table table-condensed table-hover">
                                <?php foreach ($g['siswa'] as $s): ?>
                                    <tr><td style="width:30px"><input type="checkbox" name="ikut[]" value="<?= esc($s['nisn'], 'attr') ?>" checked aria-label="Proses <?= esc($s['nama'], 'attr') ?>"></td>
                                        <td><?= esc($s['nama']) ?></td><td class="text-muted"><?= esc($s['nisn']) ?></td></tr>
                                <?php endforeach ?>
                            </table>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
            <div class="box-footer"><button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Proses Kenaikan Kelas</button></div>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
