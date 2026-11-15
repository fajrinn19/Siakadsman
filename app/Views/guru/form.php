<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-md-12">
    <div class="box box-info">
        <div class="box-header with-border"><h3 class="box-title"><?= esc($judul) ?></h3></div>
        <form method="post" action="<?= esc($action, 'attr') ?>" enctype="multipart/form-data" class="form-horizontal">
            <?= csrf_field() ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2 text-center">
                        <img class="img-thumbnail foto-profil" src="<?= foto_guru($row['foto'] ?? '') ?>" alt="Foto">
                        <div style="margin-top:8px; text-align:left">
                            <label><?= $baru ? 'Foto' : 'Ganti Foto' ?></label>
                            <input type="file" name="foto" accept="image/*"><span class="help-block">JPG/PNG maks. 2 MB.</span>
                        </div>
                    </div>
                    <?php foreach ($kolom as $judulKolom => $field): ?>
                        <div class="col-md-5">
                            <h4><?= esc($judulKolom) ?></h4>
                            <table class="table table-condensed table-bordered"><tbody>
                            <?php foreach ($field as $f): ?>
                                <?= view('crud/_field', ['f' => $f, 'row' => $row, 'baru' => $baru]) ?>
                            <?php endforeach ?>
                            </tbody></table>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-info"><?= $baru ? 'Tambahkan' : 'Update' ?></button>
                <a href="<?= $baru ? site_url('guru') : site_url('guru/detail/' . rawurlencode($row['nip'])) ?>" class="btn btn-default pull-right">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
