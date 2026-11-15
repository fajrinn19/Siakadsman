<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?= esc($judul) ?>: <b><?= esc(profil_pengguna()['nama']) ?></b></h3>
            <form class="pull-right filter-form" method="get" action="<?= site_url($segmen) ?>">
                <?= form_dropdown('tahun', $tahunOpsi, $tahun) ?>
                <button type="submit" class="btn btn-success btn-sm">Lihat</button>
            </form>
        </div>
        <div class="box-body table-responsive">
            <?php if ($tahun === ''): ?>
                <div class="pesan-kosong">Silakan pilih tahun akademik terlebih dahulu...</div>
            <?php else: ?>
                <b>CAPAIAN KOMPETENSI</b>
                <?= view('raport/_tabel_nilai', ['kelompok' => $kelompok, 'kkm' => $sekolah->kkm]) ?>
            <?php endif ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
