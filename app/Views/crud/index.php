<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?= esc($judul) ?></h3>
            <?php if ($ctrl->bisaTambah()): ?>
                <a class="pull-right btn btn-primary btn-sm" style="margin-left:5px" href="<?= site_url($segmen . '/tambah') . (array_filter($nilaiFilter) ? '?' . http_build_query(array_filter($nilaiFilter)) : '') ?>"><i class="fa fa-plus"></i> Tambah Data</a>
            <?php endif ?>
            <?php if ($filter !== []): ?>
                <form class="pull-right filter-form" method="get" action="<?= site_url($segmen) ?>">
                    <?php foreach ($filter as $nama => $f): ?>
                        <?= form_dropdown($nama, ['' => '- ' . $f['label'] . ' -'] + $f['options'], $nilaiFilter[$nama] ?? '') ?>
                    <?php endforeach ?>
                    <button type="submit" class="btn btn-success btn-sm">Lihat</button>
                </form>
            <?php endif ?>
        </div>
        <div class="box-body table-responsive">
            <?php if (! $lengkap): ?>
                <div class="pesan-kosong">Silakan pilih <?= esc(implode(' dan ', array_column($filter, 'label'))) ?> terlebih dahulu...</div>
            <?php else: ?>
                <table class="table table-bordered table-striped datatable">
                    <thead>
                    <tr>
                        <th style="width:40px">No</th>
                        <?php foreach ($kolom as $def): ?>
                            <th><?= esc(is_array($def) ? $def['label'] : $def) ?></th>
                        <?php endforeach ?>
                        <th style="width:110px">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($baris as $i => $row): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <?php foreach ($kolom as $kunci => $def): ?>
                                <td><?= $ctrl->sel($kunci, $def, $row) ?></td>
                            <?php endforeach ?>
                            <td class="aksi text-center"><?= $ctrl->aksi($row) ?></td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
