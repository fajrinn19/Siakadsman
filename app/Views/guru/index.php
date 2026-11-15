<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Data Guru</h3>
            <?php if (level() === 'superuser'): ?>
                <a class="pull-right btn btn-primary btn-sm" href="<?= site_url('guru/tambah') ?>"><i class="fa fa-plus"></i> Tambah Guru</a>
            <?php endif ?>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped datatable">
                <thead><tr><th>No</th><th>NIP</th><th>Nama Lengkap</th><th>Jenis Kelamin</th><th>No HP</th><th>Status Pegawai</th><th>Jenis PTK</th><th style="width:100px">Aksi</th></tr></thead>
                <tbody>
                <?php foreach ($baris as $i => $r): ?>
                    <?php $n = rawurlencode($r['nip']); ?>
                    <tr>
                        <td><?= $i + 1 ?></td><td><?= esc($r['nip']) ?></td><td><?= esc($r['nama_guru']) ?></td><td><?= esc($r['jenis_kelamin']) ?></td>
                        <td><?= esc($r['hp']) ?></td><td><?= esc($r['status_kepegawaian']) ?></td><td><?= esc($r['jenis_ptk']) ?></td>
                        <td class="aksi text-center">
                            <a class="btn btn-info btn-xs" title="Detail" href="<?= site_url("guru/detail/{$n}") ?>"><span class="glyphicon glyphicon-search"></span></a>
                            <?php if (level() === 'superuser'): ?>
                                <a class="btn btn-success btn-xs" title="Edit" href="<?= site_url("guru/edit/{$n}") ?>"><span class="glyphicon glyphicon-edit"></span></a>
                                <?= tombol_hapus(site_url("guru/hapus/{$n}"), 'Hapus data guru ' . $r['nama_guru'] . '?') ?>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
