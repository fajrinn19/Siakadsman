<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $id = $topik['id_forum_topic']; ?>
<div class="col-md-12">
    <div class="box box-success">
        <div class="box-header">
            <i class="fa fa-comments-o"></i>
            <h3 class="box-title"><?= esc($topik['judul_topic']) ?></h3>
            <a class="btn btn-default btn-sm pull-right" href="<?= site_url('forum/' . $topik['kodejdwl']) ?>">Kembali</a>
        </div>
        <div class="box-body chat">
            <div class="item">
                <img src="<?= foto_guru($jadwal['foto'] ?? '') ?>" alt="foto" class="online">
                <p class="message">
                    <a href="<?= site_url('guru/detail/' . rawurlencode($jadwal['nip'])) ?>" class="name">
                        <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> <?= esc($topik['waktu']) ?> WIB</small>
                        <?= esc($jadwal['nama_guru']) ?> (Guru)
                    </a>
                    <?= nl2br(esc($topik['isi_topic'])) ?>
                </p>
            </div>
            <hr>
            <?php foreach ($komentar as $k): ?>
                <?php
                if ($k['nama_siswa'] !== null) {
                    [$nama, $foto, $status] = [$k['nama_siswa'], foto_siswa($k['foto_siswa']), 'offline'];
                    $peran = 'Siswa';
                } elseif ($k['nama_guru'] !== null) {
                    [$nama, $foto, $status, $peran] = [$k['nama_guru'], foto_guru($k['foto_guru']), 'online', 'Guru'];
                } else {
                    [$nama, $foto, $status, $peran] = [$k['nama_admin'] ?? 'Admin', base_url('dist/img/user2-160x160.jpg'), 'online', 'Admin'];
                }
                ?>
                <div class="item">
                    <img src="<?= esc($foto, 'attr') ?>" alt="foto" class="<?= $status ?>">
                    <p class="message">
                        <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> <?= esc($k['waktu_komentar']) ?> WIB
                            <?php if ($kelola || $k['nisn_nip'] === session('id')): ?>
                                <?= tombol_hapus(site_url("forum/topik/{$id}/komentar/{$k['id_forum_komentar']}/hapus"), 'Hapus komentar ini?') ?>
                            <?php endif ?>
                        </small>
                        <a href="#" class="name"><?= esc($nama) ?> (<?= $peran ?>)</a>
                        <?= nl2br(esc($k['isi_komentar'])) ?>
                    </p>
                </div>
            <?php endforeach ?>
            <span id="akhir"></span>
        </div>
        <div class="box-footer">
            <form method="post" action="<?= site_url("forum/topik/{$id}") ?>">
                <?= csrf_field() ?>
                <div class="input-group">
                    <input class="form-control" name="isi_komentar" placeholder="Tuliskan komentar..." required autocomplete="off">
                    <div class="input-group-btn"><button type="submit" class="btn btn-success"><i class="fa fa-send"></i></button></div>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
