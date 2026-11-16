<?php use App\Controllers\Ppdb; ob_start(); ?>
<div class="row"><div class="col-md-6 col-md-offset-3">
    <div class="box">
        <div class="box-header with-border"><h3 class="box-title"><i class="fa fa-search"></i> Cek Status Pendaftaran</h3></div>
        <div class="box-body">
            <form method="get" action="<?= site_url('ppdb/status') ?>" class="input-group" style="margin-bottom:16px">
                <input type="text" name="kode" class="form-control" value="<?= esc($kode, 'attr') ?>" placeholder="Kode pendaftaran, mis. SMA-20261116..." required aria-label="Kode pendaftaran">
                <span class="input-group-btn"><button class="btn btn-primary" type="submit">Cek</button></span>
            </form>
            <?php if ($kode !== '' && $data === null): ?>
                <div class="alert alert-warning">Kode pendaftaran tidak ditemukan.</div>
            <?php elseif ($data): ?>
                <?php [$label, $chip] = Ppdb::STATUS[(int) ($data['proses'] ?? 0)] ?? Ppdb::STATUS[0]; ?>
                <table class="table tabel-info">
                    <tr><th>Kode</th><td><b><?= esc($data['kode_pendaftaran']) ?></b></td></tr>
                    <tr><th>Nama</th><td><?= esc($data['nama']) ?></td></tr>
                    <tr><th>Sekolah Asal</th><td><?= esc($data['sekolah_asal']) ?></td></tr>
                    <tr><th>Tanggal Daftar</th><td><?= tgl_indo($data['waktu_daftar']) ?></td></tr>
                    <tr><th>Status</th><td><span class="chip <?= $chip ?>"><?= $label ?></span></td></tr>
                </table>
            <?php endif ?>
        </div>
    </div>
</div></div>
<?= view('ppdb/_publik', ['judulHalaman' => 'Status PPDB', 'sekolah' => $sekolah, 'isi' => ob_get_clean()]) ?>
