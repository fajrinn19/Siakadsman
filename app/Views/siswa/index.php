<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $pilih = $kelas !== '' && boleh_ubah(); ?>
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Data Siswa</h3>
            <?php if (boleh_ubah()): ?>
                <a class="pull-right btn btn-success btn-sm" style="margin-left:5px" target="_blank" href="<?= site_url('siswa/cetak') . '?' . http_build_query(['kelas' => $kelas, 'angkatan' => $angkatan]) ?>"><i class="fa fa-print"></i> Cetak</a>
                <a class="pull-right btn btn-primary btn-sm" style="margin-left:5px" href="<?= site_url('siswa/tambah') ?>"><i class="fa fa-plus"></i> Tambah Siswa</a>
                <a class="pull-right btn btn-default btn-sm" style="margin-left:5px" href="<?= site_url('siswa/impor') ?>"><i class="fa fa-file-excel-o"></i> Impor Excel</a>
            <?php endif ?>
            <form class="pull-right filter-form" method="get" action="<?= site_url('siswa') ?>">
                <input type="search" name="q" placeholder="Nama / NISN" value="<?= esc($cari, 'attr') ?>" style="width:150px">
                <input type="number" name="angkatan" placeholder="Angkatan" value="<?= esc($angkatan, 'attr') ?>" style="width:100px">
                <?= form_dropdown('kelas', $kelasOpsi, $kelas) ?>
                <button type="submit" class="btn btn-info btn-sm">Lihat</button>
            </form>
        </div>
        <div class="box-body table-responsive">
            <?php if ($angkatan === '' && $kelas === '' && $cari === ''): ?>
                <div class="pesan-kosong">Silakan cari nama/NISN, isi angkatan, atau pilih kelas terlebih dahulu...</div>
            <?php else: ?>
            <form method="post" action="<?= site_url('siswa/pindah-kelas') ?>">
                <?= csrf_field() ?>
                <table class="table table-bordered table-striped datatable">
                    <thead>
                    <tr>
                        <?php if ($pilih): ?><th><input type="checkbox" id="pilihSemua" title="Pilih semua"></th><?php endif ?>
                        <th>No</th><th>NIPD</th><th>NISN</th><th>Nama Siswa</th><th>Angkatan</th><th>Jurusan</th><th>Kelas</th><th style="width:150px">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($baris as $i => $r): ?>
                        <?php $n = rawurlencode($r['nisn']); ?>
                        <tr>
                            <?php if ($pilih): ?><td><input type="checkbox" name="pilih[]" value="<?= esc($r['nisn'], 'attr') ?>" class="pilih-siswa"></td><?php endif ?>
                            <td><?= $i + 1 ?></td>
                            <td><?= esc($r['nipd']) ?></td>
                            <td><?= esc($r['nisn']) ?></td>
                            <td><?= esc($r['nama']) ?></td>
                            <td><?= esc($r['angkatan']) ?></td>
                            <td><?= esc($r['nama_jurusan']) ?></td>
                            <td><?= esc($r['nama_kelas']) ?></td>
                            <td class="aksi text-center">
                                <a class="btn btn-default btn-xs" title="Detail" href="<?= site_url("siswa/detail/{$n}") ?>"><span class="glyphicon glyphicon-search"></span></a>
                                <?php if (level() === 'superuser'): ?>
                                    <a class="btn btn-info btn-xs" title="Edit" href="<?= site_url("siswa/edit/{$n}") ?>"><span class="glyphicon glyphicon-edit"></span></a>
                                <?php endif ?>
                                <a class="btn btn-success btn-xs" title="Penilaian Diri" href="<?= site_url("siswa/{$n}/penilaian-diri") ?>"><span class="glyphicon glyphicon-th-list"></span></a>
                                <a class="btn btn-warning btn-xs" title="Penilaian Teman" href="<?= site_url("siswa/{$n}/penilaian-teman") ?>"><span class="glyphicon glyphicon-list"></span></a>
                                <?php if (boleh_ubah()): ?>
                                    <button type="submit" form="hapus-<?= esc($r['nisn'], 'attr') ?>" class="btn btn-danger btn-xs" title="Hapus"><span class="glyphicon glyphicon-remove"></span></button>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>

                <?php if ($pilih): ?>
                    <div class="well well-sm">
                        <b>Proses siswa terpilih</b> <small class="text-muted">(dicatat di riwayat kelas masing-masing siswa)</small>
                        <div class="row" style="margin-top:8px">
                            <div class="col-sm-2"><?= form_dropdown('jenis_pindah', ['Naik Kelas' => 'Naik Kelas', 'Pindah Kelas' => 'Pindah Kelas', 'Tinggal Kelas' => 'Tinggal Kelas'], 'Naik Kelas', ['class' => 'form-control input-sm', 'aria-label' => 'Jenis']) ?></div>
                            <div class="col-sm-3"><?= form_dropdown('kelas_pindah', ['' => '- Ke Kelas -'] + array_slice($kelasOpsi, 1, null, true), '', ['class' => 'form-control input-sm', 'required' => 'required', 'aria-label' => 'Kelas tujuan']) ?></div>
                            <div class="col-sm-2"><input type="number" name="angkatan_pindah" class="form-control input-sm" placeholder="Angkatan" value="<?= esc($angkatan, 'attr') ?>" aria-label="Angkatan"></div>
                            <div class="col-sm-3"><?= form_dropdown('tahun_pindah', $tahunOpsi, $tahunBawaan, ['class' => 'form-control input-sm', 'aria-label' => 'Tahun akademik']) ?></div>
                            <div class="col-sm-2"><button type="submit" class="btn btn-sm btn-info btn-block" onclick="return confirm('Proses siswa yang dipilih?')">Proses</button></div>
                        </div>
                        <input type="text" name="keterangan_pindah" class="form-control input-sm" style="margin-top:6px" placeholder="Keterangan (opsional), mis. Kenaikan kelas akhir tahun 2025/2026">
                    </div>
                <?php endif ?>
            </form>
            <?php if (boleh_ubah()): ?>
                <?php // Form hapus diletakkan di luar form pindah kelas agar tidak bersarang. ?>
                <?php foreach ($baris as $r): ?>
                    <form id="hapus-<?= esc($r['nisn'], 'attr') ?>" method="post" action="<?= site_url('siswa/hapus/' . rawurlencode($r['nisn'])) ?>" onsubmit="return confirm('Hapus data siswa <?= esc($r['nama'], 'js') ?>?')"><?= csrf_field() ?></form>
                <?php endforeach ?>
            <?php endif ?>
            <?php endif ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>$('#pilihSemua').on('change', function () { $('.pilih-siswa').prop('checked', this.checked); });</script>
<?= $this->endSection() ?>
