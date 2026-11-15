<?= $this->extend('layouts/cetak') ?>
<?= $this->section('head') ?><style>td { padding: 9px; }</style><?= $this->endSection() ?>
<?= $this->section('content') ?>
<h1 style="text-align:center">RAPORT<br><?= esc($sekolah->jenjang) ?><br><?= esc($sekolah->nama) ?></h1><br>
<table style="font-size:23px" width="100%">
    <?php foreach ([
        'Nama Sekolah' => $iden['nama_sekolah'] ?? '', 'NPSN' => $iden['npsn'] ?? '', 'NSS' => $iden['nss'] ?? '',
        'Alamat Sekolah' => $iden['alamat_sekolah'] ?? '', '' => 'Kode Pos ' . ($iden['kode_pos'] ?? '') . ', Telp. ' . ($iden['no_telpon'] ?? ''),
        'Kelurahan' => $iden['kelurahan'] ?? '', 'Kecamatan' => $iden['kecamatan'] ?? '', 'Kabupaten/Kota' => $iden['kabupaten_kota'] ?? '',
        'Provinsi' => $iden['provinsi'] ?? '', 'Website' => $iden['website'] ?? '', 'E-Mail' => $iden['email'] ?? '',
    ] as $label => $nilai): ?>
        <tr><td width="180"><?= esc($label) ?></td><td width="10"><?= $label !== '' ? ':' : '' ?></td><td><?= esc($nilai) ?></td></tr>
    <?php endforeach ?>
</table>
<?= $this->endSection() ?>
