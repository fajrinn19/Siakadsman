<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$data = [
    'NIPD' => $s['nipd'], 'NISN' => $s['nisn'], 'Nama Siswa' => $s['nama'], 'Kelas' => $s['nama_kelas'],
    'Angkatan' => $s['angkatan'], 'Jurusan' => $s['nama_jurusan'], 'Alamat' => $s['alamat'], 'RT/RW' => $s['rt'] . '/' . $s['rw'],
    'Dusun' => $s['dusun'], 'Kelurahan' => $s['kelurahan'], 'Kecamatan' => $s['kecamatan'], 'Kode Pos' => $s['kode_pos'],
    'Status Awal' => $s['status_awal'], 'Status Siswa' => $s['status_siswa'], 'NIK' => $s['nik'], 'Tempat Lahir' => $s['tempat_lahir'],
    'Tanggal Lahir' => tgl_indo($s['tanggal_lahir']), 'Jenis Kelamin' => $s['jenis_kelamin'], 'Agama' => $s['nama_agama'],
    'Kebutuhan Khusus' => $s['kebutuhan_khusus'], 'Jenis Tinggal' => $s['jenis_tinggal'], 'Transportasi' => $s['alat_transportasi'],
    'No Telpon' => $s['telepon'], 'No Handphone' => $s['hp'], 'Email' => $s['email'], 'SKHUN' => $s['skhun'],
    'Penerima KPS' => $s['penerima_kps'], 'No KPS' => $s['no_kps'],
];
$ortu = [];
foreach (['ayah' => 'Ayah', 'ibu' => 'Ibu', 'wali' => 'Wali'] as $k => $label) {
    $ortu["Nama {$label}"] = ['nilai' => $s["nama_{$k}"], 'judul' => true];
    $ortu["Tahun Lahir {$label}"] = ['nilai' => $s["tahun_lahir_{$k}"]];
    $ortu["Pendidikan {$label}"] = ['nilai' => $s["pendidikan_{$k}"]];
    $ortu["Pekerjaan {$label}"] = ['nilai' => $s["pekerjaan_{$k}"]];
    $ortu["Penghasilan {$label}"] = ['nilai' => $s["penghasilan_{$k}"]];
    if ($k !== 'wali') {
        $ortu["No Telpon {$label}"] = ['nilai' => $s["no_telpon_{$k}"]];
    }
}
?>
<div class="col-md-12">
    <div class="box box-info">
        <div class="box-header with-border"><h3 class="box-title">Detail Data Siswa</h3></div>
        <div class="box-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#siswa" data-toggle="tab">Data Siswa</a></li>
                <li><a href="#ortu" data-toggle="tab">Data Orang Tua / Wali</a></li>
                <li><a href="#riwayat" data-toggle="tab">Riwayat Kelas <span class="label label-success"><?= count($riwayat) ?></span></a></li>
            </ul>
            <br>
            <div class="row">
                <div class="col-md-2 text-center">
                    <img class="img-thumbnail foto-profil" src="<?= foto_siswa($s['foto']) ?>" alt="Foto">
                    <?php if ($bolehEdit): ?>
                        <a href="<?= site_url('siswa/edit/' . rawurlencode($s['nisn'])) ?>" class="btn btn-success btn-block" style="margin-top:8px">Edit Profil</a>
                    <?php endif ?>
                </div>
                <div class="col-md-10 tab-content">
                    <div class="tab-pane active" id="siswa">
                        <table class="table table-condensed table-bordered tabel-info"><tbody>
                        <?php foreach ($data as $label => $nilai): ?>
                            <tr><th scope="row"><?= esc($label) ?></th><td><?= esc((string) $nilai) ?></td></tr>
                        <?php endforeach ?>
                        </tbody></table>
                    </div>
                    <div class="tab-pane" id="riwayat">
                        <?= view('siswa/_riwayat', ['s' => $s, 'riwayat' => $riwayat]) ?>
                    </div>
                    <div class="tab-pane" id="ortu">
                        <table class="table table-condensed table-bordered tabel-info"><tbody>
                        <?php foreach ($ortu as $label => $o): ?>
                            <tr<?= ! empty($o['judul']) ? ' style="background:#e3e3e3"' : '' ?>><th scope="row"><?= esc($label) ?></th><td><?= esc((string) $o['nilai']) ?></td></tr>
                        <?php endforeach ?>
                        </tbody></table>
                    </div>
                </div>
            </div>
        </div>
        <?php if (level() !== 'siswa'): ?>
            <div class="box-footer"><a href="javascript:history.back()" class="btn btn-default pull-right">Kembali</a></div>
        <?php endif ?>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>if (location.hash) { $('a[href="' + location.hash + '"]').tab('show'); }</script>
<?= $this->endSection() ?>
