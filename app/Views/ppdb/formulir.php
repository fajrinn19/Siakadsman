<?php ob_start(); ?>
<?php if (! $buka): ?>
    <div class="box"><div class="box-body pesan-kosong">Pendaftaran peserta didik baru sedang ditutup.</div></div>
<?php else: ?>
<form method="post" action="<?= site_url('ppdb') ?>">
    <?= csrf_field() ?>
    <div class="row">
        <?php foreach ($field as $judul => $daftar): ?>
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border"><h3 class="box-title"><?= esc($judul) ?></h3></div>
                    <div class="box-body">
                        <table class="table table-condensed"><tbody>
                        <?php foreach ($daftar as $f): ?>
                            <?= view('crud/_field', ['f' => $f, 'row' => [], 'baru' => true]) ?>
                        <?php endforeach ?>
                        </tbody></table>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
    <div class="box"><div class="box-body">
        <p class="text-muted">Dengan mengirim formulir ini, Anda menyatakan data yang diisi benar. Setelah terkirim, Anda mendapat <b>kode pendaftaran</b> untuk mengecek status.</p>
        <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-paper-plane"></i> Kirim Pendaftaran</button>
    </div></div>
</form>
<?php endif ?>
<?= view('ppdb/_publik', ['judulHalaman' => 'Formulir PPDB', 'sekolah' => $sekolah, 'isi' => ob_get_clean()]) ?>
