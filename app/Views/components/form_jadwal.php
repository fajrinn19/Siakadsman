<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-md-12">
    <div class="box box-info">
        <div class="box-header with-border"><h3 class="box-title"><?= esc($judul) ?></h3></div>
        <form method="post" action="<?= esc($action, 'attr') ?>" class="form-horizontal">
            <?= csrf_field() ?>
            <div class="box-body">
                <?= view('components/info_jadwal', ['jadwal' => $jadwal]) ?>
                <table class="table table-condensed table-bordered"><tbody>
                <?php foreach ($field as $f): ?>
                    <?= view('crud/_field', ['f' => $f, 'row' => $row, 'baru' => $baru]) ?>
                <?php endforeach ?>
                </tbody></table>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-info"><?= $baru ? 'Tambahkan' : 'Update' ?></button>
                <a href="<?= esc($batal, 'attr') ?>" class="btn btn-default pull-right">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
