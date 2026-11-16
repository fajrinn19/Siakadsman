<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php use App\Controllers\Ppdb; ?>
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><i class="fa fa-user-plus"></i> Pendaftar PPDB</h3>
            <span class="chip <?= $buka ? 'chip-aktif' : 'chip-redup' ?>" style="margin-left:8px"><?= $buka ? 'Pendaftaran dibuka' : 'Pendaftaran ditutup' ?></span>
            <div class="pull-right">
                <a class="btn btn-default btn-sm" target="_blank" href="<?= site_url('ppdb') ?>"><i class="fa fa-external-link"></i> Formulir Publik</a>
                <form class="filter-form" style="display:inline" method="get" action="<?= site_url('ppdb/admin') ?>">
                    <?= form_dropdown('status', ['' => 'Semua status', '0' => 'Menunggu', '1' => 'Diterima', '2' => 'Tidak diterima'], $status, ['onchange' => 'this.form.submit()', 'aria-label' => 'Status']) ?>
                </form>
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-hover datatable">
                <thead><tr><th>No</th><th>Kode</th><th>Nama</th><th>Sekolah Asal</th><th>No HP</th><th>Tanggal</th><th>Status</th><th></th></tr></thead>
                <tbody>
                <?php foreach ($baris as $i => $r): ?>
                    <?php [$label, $chip] = Ppdb::STATUS[(int) $r['proses']] ?? Ppdb::STATUS[0]; ?>
                    <tr><td><?= $i + 1 ?></td><td><code><?= esc($r['kode_pendaftaran']) ?></code></td><td><?= esc($r['nama']) ?></td><td><?= esc($r['sekolah_asal']) ?></td>
                        <td><?= esc($r['no_telpon']) ?></td><td><?= tgl_indo($r['waktu_daftar']) ?></td><td><span class="chip <?= $chip ?>"><?= $label ?></span></td>
                        <td><a class="btn btn-primary btn-xs" href="<?= site_url('ppdb/admin/' . $r['id_pendaftaran']) ?>"><i class="fa fa-search"></i> Detail</a></td></tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
