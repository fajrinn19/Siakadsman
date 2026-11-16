<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-xs-12">
    <div class="box">
        <div class="box-header"><h3 class="box-title"><?= esc($judul) ?></h3>
            <?= view('raport/_filter', ['segmen' => $segmen, 'tahunOpsi' => $tahunOpsi, 'kelasOpsi' => $kelasOpsi, 'tahun' => $tahun, 'kelas' => $kelas]) ?></div>
        <div class="box-body table-responsive">
            <?php if (! $lengkap): ?>
                <div class="pesan-kosong">Silakan pilih tahun akademik dan kelas terlebih dahulu...</div>
            <?php else: ?>
                <p>
                    <a class="btn btn-default btn-sm" href="<?= site_url('raport/ekspor-nilai') . '?' . http_build_query(['tahun' => $tahun, 'kelas' => $kelas]) ?>"><i class="fa fa-file-excel-o"></i> Ekspor Nilai Kelas (Excel)</a>
                    <?php if (! $uts): ?>
                        <a class="btn btn-primary btn-sm" target="_blank" href="<?= site_url('raport/pdf-kelas') . '?' . http_build_query(['tahun' => $tahun, 'kelas' => $kelas, 'format' => 'k13']) ?>"><i class="fa fa-file-pdf-o"></i> PDF Satu Kelas (K13)</a>
                        <a class="btn btn-primary btn-sm" target="_blank" href="<?= site_url('raport/pdf-kelas') . '?' . http_build_query(['tahun' => $tahun, 'kelas' => $kelas, 'format' => 'merdeka']) ?>"><i class="fa fa-file-pdf-o"></i> PDF Satu Kelas (Merdeka)</a>
                    <?php endif ?>
                </p>
                <table class="table table-bordered table-striped datatable">
                    <thead><tr><th>No</th><th>NIPD</th><th>NISN</th><th>Nama Siswa</th><th>Jenis Kelamin</th><th>Cetak</th></tr></thead>
                    <tbody>
                    <?php foreach ($siswa as $i => $s): ?>
                        <?php $q = '?' . http_build_query(['tahun' => $tahun, 'kelas' => $kelas]); $n = rawurlencode($s['nisn']); ?>
                        <tr>
                            <td style="width:40px"><?= $i + 1 ?></td><td><?= esc($s['nipd']) ?></td><td><?= esc($s['nisn']) ?></td><td><?= esc($s['nama']) . label_mantan($s) ?></td><td><?= esc($s['jenis_kelamin']) ?></td>
                            <td class="aksi" style="width:<?= $uts ? '140' : '560' ?>px">
                                <?php if ($uts): ?>
                                    <a target="_blank" class="btn btn-primary btn-xs" href="<?= site_url("raport/print/uts/{$n}") . $q ?>"><span class="glyphicon glyphicon-print"></span> Raport UTS</a>
                                <?php else: ?>
                                    <a target="_blank" class="btn btn-primary btn-xs" href="<?= site_url("raport/pdf/{$n}") . $q ?>&format=k13" title="Semua halaman (K13) dalam satu PDF"><i class="fa fa-file-pdf-o"></i> PDF</a>
                                    <a target="_blank" class="btn btn-primary btn-xs" href="<?= site_url("raport/pdf/{$n}") . $q ?>&format=merdeka" title="Format Kurikulum Merdeka"><i class="fa fa-file-pdf-o"></i> Merdeka</a>
                                    <?php foreach (['cover' => 'Cover', '1' => 'Hal 1', '2' => 'Hal 2', '3' => 'Hal 3', '4' => 'Hal 4', '5' => 'Hal 5', '6' => 'Hal 6'] as $h => $label): ?>
                                        <a target="_blank" class="btn btn-success btn-xs" href="<?= site_url("raport/print/{$h}/{$n}") . $q ?>"><span class="glyphicon glyphicon-print"></span> <?= $label ?></a>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
