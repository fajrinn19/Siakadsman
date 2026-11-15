<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-md-12">
    <div class="box box-info">
        <div class="box-header with-border"><h3 class="box-title"><?= esc($judul) ?></h3></div>
        <div class="box-body">
            <?php if (! empty($peringatanSiswa)): ?>
                <div class="alert alert-warning"><strong>Perhatian!</strong> Data di bawah ini digunakan untuk keperluan sekolah. Isilah sesuai data sebenarnya.</div>
            <?php endif ?>

            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#siswa" data-toggle="tab">Data Siswa</a></li>
                <li><a href="#ortu" data-toggle="tab">Data Orang Tua / Wali</a></li>
            </ul>
            <br>

            <?php // Saat tambah, kedua tab ada dalam satu form. Saat edit, data siswa & orang tua disimpan terpisah. ?>
            <form method="post" action="<?= esc($action, 'attr') ?>" enctype="multipart/form-data" class="form-horizontal" id="formSiswa"><?= csrf_field() ?></form>
            <?php if (! $baru): ?>
                <form method="post" action="<?= esc($actionOrtu, 'attr') ?>" class="form-horizontal" id="formOrtu"><?= csrf_field() ?></form>
            <?php endif ?>

            <div class="tab-content">
                <div class="tab-pane active" id="siswa">
                    <div class="row">
                        <div class="col-md-2 text-center">
                            <img class="img-thumbnail foto-profil" src="<?= foto_siswa($row['foto'] ?? '') ?>" alt="Foto">
                        </div>
                        <div class="col-md-10">
                            <table class="table table-condensed table-bordered">
                                <tbody>
                                <?php foreach ($fieldData as $f): ?>
                                    <?= view('crud/_field', ['f' => $f, 'row' => $row, 'baru' => $baru, 'form' => 'formSiswa']) ?>
                                <?php endforeach ?>
                                <tr>
                                    <th scope="row"><?= $baru ? 'Foto' : 'Ganti Foto' ?></th>
                                    <td><input type="file" name="foto" accept="image/*" form="formSiswa"><span class="help-block">JPG/PNG maksimal 2 MB.</span></td>
                                </tr>
                                </tbody>
                            </table>
                            <?php if (! $baru): ?>
                                <button type="submit" form="formSiswa" class="btn btn-info">Simpan Data Siswa</button>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="ortu">
                    <table class="table table-condensed table-bordered">
                        <tbody>
                        <?php $target = $baru ? 'formSiswa' : 'formOrtu'; ?>
                        <?php foreach ($fieldOrtu as $f): ?>
                            <?= view('crud/_field', ['f' => $f, 'row' => $row, 'baru' => $baru, 'form' => $target]) ?>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                    <?php if (! $baru): ?>
                        <button type="submit" form="formOrtu" class="btn btn-info">Simpan Data Orang Tua</button>
                    <?php endif ?>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <?php if ($baru): ?><button type="submit" form="formSiswa" class="btn btn-info">Tambahkan</button><?php endif ?>
            <a href="<?= level() === 'siswa' ? site_url('siswa/detail/' . rawurlencode((string) session('id'))) : site_url('siswa') ?>" class="btn btn-default pull-right">Kembali</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>if (location.hash === '#ortu') { $('a[href="#ortu"]').tab('show'); }</script>
<?= $this->endSection() ?>
