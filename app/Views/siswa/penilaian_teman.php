<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-xs-12">
    <div class="box">
        <div class="box-header"><h3 class="box-title"><?= esc($judul) ?></h3></div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped datatable">
                <thead><tr><th style="width:40px">No</th><th>NIPD</th><th>NISN</th><th>Nama Siswa</th><th>Angkatan</th><th>Jurusan</th><th>Kelas</th><th></th></tr></thead>
                <tbody>
                <?php foreach ($teman as $i => $t): ?>
                    <tr>
                        <td><?= $i + 1 ?></td><td><?= esc($t['nipd']) ?></td><td><?= esc($t['nisn']) ?></td><td><?= esc($t['nama']) ?></td>
                        <td><?= esc($t['angkatan']) ?></td><td><?= esc($t['nama_jurusan']) ?></td><td><?= esc($t['nama_kelas']) ?></td>
                        <td class="text-center"><a class="btn btn-success btn-xs" href="<?= esc($url($t), 'attr') ?>"><span class="glyphicon glyphicon-search"></span> <?= esc($labelTombol) ?></a></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
