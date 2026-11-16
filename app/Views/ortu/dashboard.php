<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $total = array_sum($absen); ?>
<div class="col-lg-3 col-md-4">
    <div class="kartu-ringkasan">
        <h3>Anak Anda</h3>
        <div style="display:flex; align-items:center; gap:12px">
            <img src="<?= foto_siswa($anak['foto']) ?>" alt="Foto" style="width:56px; height:56px; border-radius:50%; object-fit:cover; border:2px solid #fff">
            <div><b style="font-size:16px"><?= esc($anak['nama']) ?></b><br><span class="label-besar"><?= esc($anak['nama_kelas']) ?> &middot; NISN <?= esc($anak['nisn']) ?></span></div>
        </div>
        <div class="baris-statistik" style="margin-bottom:0">
            <span><b><?= $total > 0 ? round($absen['H'] / $total * 100) : 0 ?>%</b> Kehadiran</span>
            <span><b><?= count(array_filter($tugas, static fn ($t) => ! $t['dikirim'] && ! $t['habis'])) ?></b> Tugas belum dikirim</span>
        </div>
    </div>
    <?php foreach ([['Hadir', 'H', 'fa-check', '#0f6b5c'], ['Sakit', 'S', 'fa-medkit', '#f5b71a'], ['Izin', 'I', 'fa-envelope-o', '#17a589'], ['Alpa', 'A', 'fa-times', '#f28c70']] as [$label, $k, $ikon, $warna]): ?>
        <a href="<?= site_url('ortu/absensi') ?>" class="kartu kartu-mini" style="padding:12px 16px">
            <span class="ikon" style="color:<?= $warna ?>"><i class="fa <?= $ikon ?>"></i></span>
            <div class="judul"><?= $label ?></div><div class="judul-kecil">semester ini</div>
            <span style="position:absolute; right:18px; top:16px; font-size:22px; font-weight:700"><?= $absen[$k] ?></span>
        </a>
    <?php endforeach ?>
</div>
<div class="col-lg-9 col-md-8">
    <?= view('dashboard/_info', ['pengumuman' => $pengumuman, 'agenda' => $agenda]) ?>
    <?= view('ortu/_tugas', ['tugas' => $tugas, 'judulBox' => 'Tugas Terbaru', 'semua' => true]) ?>
</div>
<?= $this->endSection() ?>
