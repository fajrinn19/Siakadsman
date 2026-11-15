<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-md-12">
    <div class="box box-info">
        <div class="box-header with-border"><h3 class="box-title"><?= esc($judul) ?></h3></div>
        <div class="box-body">
            <table class="table table-condensed table-bordered tabel-info">
                <tbody>
                <?php foreach ($baris as $label => $nilai): ?>
                    <tr><th scope="row"><?= esc($label) ?></th><td><?= esc($nilai) ?></td></tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <div class="box-footer">
            <?php if ($bolehUbah): ?>
                <a href="<?= site_url($segmen . '/edit/' . rawurlencode($id)) ?>" class="btn btn-success">Edit</a>
            <?php endif ?>
            <a href="<?= site_url($segmen) ?>" class="btn btn-default pull-right">Kembali</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
