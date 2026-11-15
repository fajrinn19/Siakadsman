<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-md-12">
    <div class="box box-info">
        <div class="box-header with-border"><h3 class="box-title"><?= esc($judul) ?></h3></div>
        <form method="post" action="<?= esc($action, 'attr') ?>" enctype="multipart/form-data" class="form-horizontal">
            <?= csrf_field() ?>
            <div class="box-body">
                <?= view('components/info_jadwal', ['jadwal' => $jadwal]) ?>
                <table class="table table-condensed table-bordered"><tbody>
                <?php foreach ($field as $f): ?>
                    <?= view('crud/_field', ['f' => $f, 'row' => $row, 'baru' => $baru]) ?>
                <?php endforeach ?>
                <tr>
                    <th scope="row"><?= $baru ? 'File' : 'Ganti File' ?></th>
                    <td><input type="file" name="file">
                        <?php if (! $baru && ($row['file_upload'] ?? '') !== ''): ?><span class="help-block">File saat ini: <?= esc($row['file_upload']) ?></span><?php endif ?>
                        <span class="help-block">Maksimal 20 MB (pdf, doc/x, xls/x, ppt/x, gambar, zip, rar, txt, mp4).</span></td>
                </tr>
                </tbody></table>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-info"><?= $baru ? 'Tambahkan' : 'Update' ?></button>
                <a href="<?= site_url('bahan-tugas/' . $jadwal['kodejdwl']) ?>" class="btn btn-default pull-right">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
