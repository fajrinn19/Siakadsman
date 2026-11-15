<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $k = $jadwal['kodejdwl']; ?>
<div class="col-md-12">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Input Nilai Sikap Siswa</h3>
            <div class="pull-right">
                <a class="btn btn-success btn-sm" href="<?= site_url("nilai/{$k}/pengetahuan") ?>">Pengetahuan</a>
                <a class="btn btn-primary btn-sm" href="<?= site_url("nilai/{$k}/keterampilan") ?>">Keterampilan</a>
                <a class="btn btn-default btn-sm" href="<?= site_url('nilai') ?>">Kembali</a>
            </div>
        </div>
        <div class="box-body">
            <?= view('components/info_jadwal', ['jadwal' => $jadwal]) ?>
            <ul class="nav nav-tabs">
                <li class="active"><a href="#spiritual" data-toggle="tab">Penilaian Spiritual</a></li>
                <li><a href="#sosial" data-toggle="tab">Penilaian Sosial</a></li>
            </ul>
            <br>
            <div class="tab-content">
                <?php foreach (['spiritual', 'sosial'] as $i => $status): ?>
                    <div class="tab-pane<?= $i === 0 ? ' active' : '' ?>" id="<?= $status ?>">
                        <form method="post" action="<?= site_url("nilai/{$k}/sikap") ?>">
                            <?= csrf_field() ?>
                            <input type="hidden" name="status" value="<?= $status ?>">
                            <table class="table table-bordered table-condensed">
                                <thead><tr><th style="width:30px">No</th><th style="width:100px">NISN</th><th style="width:170px">Nama</th><th>Positif</th><th>Negatif</th><th>Deskripsi</th></tr></thead>
                                <tbody>
                                <?php foreach ($siswa as $j => $s): ?>
                                    <?php $n = $nilai[$status][$s['nisn']] ?? []; $nama = 'sikap[' . esc($s['nisn'], 'attr') . ']'; ?>
                                    <tr>
                                        <td><?= $j + 1 ?></td><td><?= esc($s['nisn']) ?></td><td><?= esc($s['nama']) ?></td>
                                        <?php foreach (['positif', 'negatif', 'deskripsi'] as $kol): ?>
                                            <td><textarea name="<?= $nama ?>[<?= $kol ?>]" class="form-control" rows="2" placeholder="Tuliskan <?= $kol ?>..."<?= boleh_ubah() ? '' : ' readonly' ?>><?= esc($n[$kol] ?? '') ?></textarea></td>
                                        <?php endforeach ?>
                                    </tr>
                                <?php endforeach ?>
                                </tbody>
                            </table>
                            <?php if (boleh_ubah()): ?><button type="submit" class="btn btn-info">Simpan Sikap <?= ucfirst($status) ?></button><?php endif ?>
                        </form>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>if (location.hash === '#sosial') { $('a[href="#sosial"]').tab('show'); }</script>
<?= $this->endSection() ?>
