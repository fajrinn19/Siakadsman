<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
use App\Libraries\Raport;

$k     = $jadwal['kodejdwl'];
$n     = count($cfg['kolom']);
$ubah  = boleh_ubah();
$label = $cfg['rumus'] === 'maks' ? 'Nilai' : 'Rata2';
?>
<div class="col-md-12">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><?= esc($judul) ?></h3>
            <div class="pull-right">
                <a class="btn btn-warning btn-sm" href="<?= site_url("nilai/{$k}/sikap") ?>">Sikap</a>
                <a class="btn btn-success btn-sm" href="<?= site_url("nilai/{$k}/pengetahuan") ?>">Pengetahuan</a>
                <a class="btn btn-primary btn-sm" href="<?= site_url("nilai/{$k}/keterampilan") ?>">Keterampilan</a>
                <a class="btn btn-default btn-sm" href="<?= site_url('nilai') ?>">Kembali</a>
            </div>
        </div>
        <div class="box-body table-responsive">
            <?= view('components/info_jadwal', ['jadwal' => $jadwal]) ?>
            <p class="text-muted">
                <?= $cfg['rumus'] === 'maks' ? 'Nilai per KD = nilai tertinggi.' : 'Nilai per KD = rata-rata.' ?>
                Nilai raport = rata-rata nilai seluruh KD. Deskripsi raport diambil dari KD dengan nilai tertinggi.
            </p>
            <table class="table table-condensed tabel-nilai">
                <thead>
                <tr>
                    <th rowspan="2" style="width:30px">No</th>
                    <th rowspan="2" style="width:170px">Nama Lengkap</th>
                    <th rowspan="2" class="text-center" style="width:55px">KD</th>
                    <th colspan="<?= $n ?>" class="text-center">Penilaian</th>
                    <th rowspan="2" class="text-center" style="width:55px"><?= $label ?></th>
                    <th rowspan="2" class="text-center" style="width:55px">Grade</th>
                    <th rowspan="2" class="text-center">Deskripsi</th>
                    <th rowspan="2" class="text-center" style="width:75px">Aksi</th>
                </tr>
                <tr><?php foreach ($cfg['header'] as $h): ?><th class="text-center" style="width:55px"><?= esc($h) ?></th><?php endforeach ?></tr>
                </thead>
                <tbody>
                <?php foreach ($siswa as $i => $s): ?>
                    <?php
                    $nilaiSiswa = $entri[$s['nisn']] ?? [];
                    $sedangEdit = $edit !== null && $edit['nisn'] === $s['nisn'];
                    $isi        = $sedangEdit ? $edit : [];
                    $ringkas    = Raport::ringkas($nilaiSiswa);
                    $formId     = 'f' . $s['nisn'];
                    ?>
                    <tr id="s<?= esc($s['nisn'], 'attr') ?>" style="background:#f9f9f9">
                        <td><?= $i + 1 ?></td>
                        <td style="font-size:12px"><b><?= esc($s['nama']) ?></b></td>
                        <?php if ($ubah): ?>
                            <td class="text-center"><input type="text" name="kd" form="<?= $formId ?>" value="<?= esc($isi['kd'] ?? '', 'attr') ?>" required></td>
                            <?php foreach ($cfg['kolom'] as $kol): ?>
                                <td class="text-center"><input type="number" step="0.01" min="0" max="100" name="<?= $kol ?>" form="<?= $formId ?>" value="<?= esc(isset($isi[$kol]) ? (string) (float) $isi[$kol] : '', 'attr') ?>"></td>
                            <?php endforeach ?>
                            <td></td><td></td>
                            <td><input type="text" name="deskripsi" form="<?= $formId ?>" value="<?= esc($isi['deskripsi'] ?? '', 'attr') ?>" style="width:100%"></td>
                            <td class="text-center">
                                <form id="<?= $formId ?>" method="post" action="<?= site_url("nilai/{$k}/{$jenis}") ?>" style="margin:0">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="nisn" value="<?= esc($s['nisn'], 'attr') ?>">
                                    <input type="hidden" name="id" value="<?= $sedangEdit ? (int) $edit[$cfg['pk']] : '' ?>">
                                    <button type="submit" class="btn btn-xs btn-primary" style="width:65px"><?= $sedangEdit ? 'Update' : 'Simpan' ?></button>
                                </form>
                            </td>
                        <?php else: ?>
                            <td colspan="<?= $n + 5 ?>"></td>
                        <?php endif ?>
                    </tr>
                    <?php foreach ($nilaiSiswa as $e): ?>
                        <tr>
                            <td></td><td></td>
                            <td class="text-center"><?= esc($e['kd']) ?></td>
                            <?php foreach ($cfg['kolom'] as $kol): ?><td class="text-center"><?= nilai_angka($e[$kol]) ?></td><?php endforeach ?>
                            <td class="text-center"><?= nilai_angka($e['nilai_kd']) ?></td>
                            <td class="text-center"><?= esc($grade($e['nilai_kd'])) ?></td>
                            <td><?= esc($e['deskripsi']) ?></td>
                            <td class="text-center aksi">
                                <?php if ($ubah): ?>
                                    <a href="<?= site_url("nilai/{$k}/{$jenis}") . '?edit=' . $e[$cfg['pk']] . '#s' . rawurlencode($s['nisn']) ?>" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-edit"></span></a>
                                    <?= tombol_hapus(site_url("nilai/{$k}/{$jenis}/hapus/" . $e[$cfg['pk']])) ?>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    <?php if ($nilaiSiswa !== []): ?>
                        <tr><td></td><td></td><td colspan="<?= $n + 1 ?>" class="text-center">Nilai Tertinggi</td>
                            <td class="text-center"><?= nilai_angka($ringkas['tertinggi']) ?></td><td class="text-center"><?= esc($grade($ringkas['tertinggi'])) ?></td><td colspan="2"></td></tr>
                        <tr style="font-weight:bold"><td></td><td></td><td colspan="<?= $n + 1 ?>" class="text-center">Raport</td>
                            <td class="text-center"><?= nilai_angka($ringkas['raport']) ?></td><td class="text-center"><?= esc($grade($ringkas['raport'])) ?></td><td colspan="2"><?= esc($ringkas['deskripsi']) ?></td></tr>
                    <?php endif ?>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
