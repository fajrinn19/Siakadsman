<?= $this->extend('layouts/cetak') ?>
<?= $this->section('head') ?><style>td { padding: 2px; }</style><?= $this->endSection() ?>
<?= $this->section('content') ?>
<h1 style="text-align:center">IDENTITAS PESERTA DIDIK</h1><br>
<table style="font-size:15px" width="100%">
    <?php foreach ([
        ['1.', 'Nama Lengkap Peserta Didik', $s['nama']],
        ['2.', 'Nomor Induk / NISN', $s['nipd'] . ' / ' . $s['nisn']],
        ['3.', 'Tempat, Tanggal Lahir', $s['tempat_lahir'] . ', ' . tgl_raport($s['tanggal_lahir'])],
        ['4.', 'Jenis Kelamin', $s['jenis_kelamin']],
        ['5.', 'Agama', $s['nama_agama']],
        ['6.', 'Status dalam Keluarga', 'Anak Kandung'],
        ['7.', 'Anak ke', '-'],
        ['8.', 'Alamat Peserta Didik', $s['alamat']],
        ['9.', 'Nomor Telepon Rumah', $s['telepon']],
        ['10.', 'Sekolah Asal (SMP/MTs)', ''],
        ['11.', 'Diterima di sekolah ini', ''],
        ['', 'Di Kelas', $masuk['kelas'] ?? $s['kode_kelas']],
        ['', 'Pada Tanggal', ! empty($masuk['tanggal']) ? tgl_raport($masuk['tanggal']) : ''],
        ['12.', 'Orang Tua', ''],
        ['', 'a. Nama Ayah', $s['nama_ayah']],
        ['', 'b. Nama Ibu', $s['nama_ibu']],
        ['', 'c. Alamat', $s['alamat']],
        ['', 'd. Nomor Telepon/HP', $s['no_telpon_ayah'] ?: $s['no_telpon_ibu']],
        ['13.', 'Pekerjaan Orang Tua', ''],
        ['', 'a. Ayah', $s['pekerjaan_ayah']],
        ['', 'b. Ibu', $s['pekerjaan_ibu']],
        ['14.', 'Wali Peserta Didik', ''],
        ['', 'a. Nama Wali', $s['nama_wali']],
        ['', 'b. Pekerjaan', $s['pekerjaan_wali']],
    ] as [$no, $label, $nilai]): ?>
        <tr><td width="25"><?= $no ?></td><td width="200"><?= esc($label) ?></td><td width="10">:</td><td><?= esc((string) $nilai) ?></td></tr>
    <?php endforeach ?>
</table>
<br><br>
<table width="40%" style="float:right">
    <tr><td><?= esc($sekolah->kota) ?>, <?= tgl_raport(date('Y-m-d')) ?><br>Kepala Sekolah,<br><br><br><br>
        <b><?= esc($sekolah->kepalaNama) ?><br>NIP: <?= esc($sekolah->kepalaNip) ?></b></td></tr>
</table>
<?= $this->endSection() ?>
