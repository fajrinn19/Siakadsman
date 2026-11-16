<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $warna = ['H' => 'chip-aktif', 'S' => 'chip-tunggu', 'I' => 'chip-tunggu', 'A' => 'chip-redup']; ?>
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?= esc($judul) ?></h3>
            <form class="pull-right filter-form" method="get" action="<?= site_url('ortu/absensi') ?>"><?= form_dropdown('tahun', $tahunOpsi, $tahun, ['onchange' => 'this.form.submit()', 'aria-label' => 'Tahun akademik']) ?></form>
        </div>
        <div class="box-body table-responsive">
            <p><span class="chip chip-aktif">Hadir <?= $jumlah['H'] ?></span> <span class="chip chip-tunggu">Sakit <?= $jumlah['S'] ?></span>
                <span class="chip chip-tunggu">Izin <?= $jumlah['I'] ?></span> <span class="chip chip-redup">Alpa <?= $jumlah['A'] ?></span></p>
            <table class="table table-hover datatable">
                <thead><tr><th>Tanggal</th><th>Hari</th><th>Mata Pelajaran</th><th>Jam</th><th>Kehadiran</th></tr></thead>
                <tbody>
                <?php foreach ($baris as $r): ?>
                    <tr><td><?= tgl_indo($r['tanggal']) ?></td><td><?= hari_ini($r['tanggal']) ?></td><td><?= esc($r['namamatapelajaran']) ?></td>
                        <td><?= esc(substr($r['jam_mulai'], 0, 5)) ?></td><td><span class="chip <?= $warna[$r['kode_kehadiran']] ?? 'chip-redup' ?>"><?= esc($r['nama_kehadiran'] ?? $r['kode_kehadiran']) ?></span></td></tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
