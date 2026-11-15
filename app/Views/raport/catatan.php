<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $jumlahKolom = count($kolom); ?>
<div class="col-xs-12">
    <div class="box">
        <div class="box-header"><h3 class="box-title"><?= esc($judul) ?></h3>
            <?= view('raport/_filter', ['segmen' => $segmen, 'tahunOpsi' => $tahunOpsi, 'kelasOpsi' => $kelasOpsi, 'tahun' => $tahun, 'kelas' => $kelas]) ?></div>
        <div class="box-body table-responsive">
            <?php if (! $lengkap): ?>
                <div class="pesan-kosong">Silakan pilih tahun akademik dan kelas terlebih dahulu...</div>
            <?php else: ?>
                <table class="table table-bordered table-condensed">
                    <thead><tr><th>No</th><th>NISN</th><th style="width:170px">Nama Siswa</th>
                        <?php foreach ($kolom as $k): ?><th class="text-center"<?= isset($k['lebar']) ? ' style="width:' . $k['lebar'] . '"' : '' ?>><?= esc($k['label']) ?></th><?php endforeach ?>
                        <th class="text-center" style="width:80px">Aksi</th></tr></thead>
                    <tbody>
                    <?php foreach ($siswa as $i => $s): ?>
                        <?php $sedangEdit = $edit !== null && $edit['nisn'] === $s['nisn']; $form = 'f' . $s['nisn']; ?>
                        <tr id="s<?= esc($s['nisn'], 'attr') ?>" style="background:#f9f9f9">
                            <td><?= $i + 1 ?></td><td><?= esc($s['nisn']) ?></td><td style="font-size:12px"><b><?= esc($s['nama']) . label_mantan($s) ?></b></td>
                            <?php if (boleh_ubah()): ?>
                                <?php foreach ($kolom as $nama => $k): ?>
                                    <td><input type="<?= $k['tipe'] ?? 'text' ?>" class="form-control input-sm" form="<?= $form ?>" name="<?= $nama ?>" value="<?= esc($sedangEdit ? (string) $edit[$nama] : '', 'attr') ?>" placeholder="<?= esc($k['label'], 'attr') ?>..."></td>
                                <?php endforeach ?>
                                <td class="text-center">
                                    <form id="<?= $form ?>" method="post" action="<?= site_url($segmen) ?>" style="margin:0">
                                        <?= csrf_field() ?>
                                        <?= form_hidden(['tahun' => $tahun, 'kelas' => $kelas, 'nisn' => $s['nisn'], 'id' => $sedangEdit ? (string) $edit[$pk] : '']) ?>
                                        <button type="submit" class="btn btn-xs btn-primary" style="width:65px"><?= $sedangEdit ? 'Update' : 'Simpan' ?></button>
                                    </form>
                                </td>
                            <?php else: ?>
                                <td colspan="<?= $jumlahKolom + 1 ?>"></td>
                            <?php endif ?>
                        </tr>
                        <?php foreach ($entri[$s['nisn']] ?? [] as $e): ?>
                            <tr><td></td><td></td><td></td>
                                <?php foreach (array_keys($kolom) as $nama): ?><td><?= esc((string) $e[$nama]) ?></td><?php endforeach ?>
                                <td class="text-center aksi">
                                    <?php if (boleh_ubah()): ?>
                                        <a class="btn btn-xs btn-success" href="<?= site_url($segmen) . '?' . http_build_query(['tahun' => $tahun, 'kelas' => $kelas, 'edit' => $e[$pk]]) . '#s' . rawurlencode($s['nisn']) ?>"><span class="glyphicon glyphicon-edit"></span></a>
                                        <?= tombol_hapus(site_url($segmen . '/hapus/' . $e[$pk])) ?>
                                    <?php endif ?>
                                </td></tr>
                        <?php endforeach ?>
                    <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
