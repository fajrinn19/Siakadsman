<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-xs-12">
    <div class="box">
        <div class="box-header"><h3 class="box-title"><i class="fa fa-graduation-cap"></i> Data Alumni</h3></div>
        <div class="box-body table-responsive">
            <table class="table table-hover datatable">
                <thead><tr><th>No</th><th>NISN</th><th>Nama</th><th>Angkatan</th><th>Kelas Terakhir</th><th>Tahun Lulus</th><th>Dicatat</th><th></th></tr></thead>
                <tbody>
                <?php foreach ($baris as $i => $r): ?>
                    <tr><td><?= $i + 1 ?></td><td><?= esc($r['nisn']) ?></td><td><?= esc($r['nama']) ?></td><td><?= esc((string) $r['angkatan']) ?></td>
                        <td><?= esc($r['kode_kelas_asal']) ?></td><td><?= esc($r['nama_tahun'] ?? $r['id_tahun_akademik']) ?></td><td><?= tgl_indo($r['waktu']) ?></td>
                        <td><a class="btn btn-default btn-xs" href="<?= site_url('siswa/detail/' . rawurlencode($r['nisn'])) ?>#riwayat"><i class="fa fa-search"></i></a></td></tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
