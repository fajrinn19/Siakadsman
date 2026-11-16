<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-xs-12">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-level-up"></i> Langkah 1 — Petakan Kelas Asal ke Kelas Tujuan</h3>
            <a class="btn btn-default btn-sm pull-right" href="<?= site_url('alumni') ?>"><i class="fa fa-graduation-cap"></i> Data Alumni</a>
        </div>
        <form method="post" action="<?= site_url('kenaikan-kelas/pratinjau') ?>">
            <?= csrf_field() ?>
            <div class="box-body">
                <p class="text-muted">Saran tujuan diisi otomatis dari kode kelas (X → XI, XI → XII, XII → Lulus). Ubah bila perlu.
                    Siswa yang tinggal kelas bisa dikecualikan pada langkah berikutnya.</p>
                <div class="row" style="margin-bottom:12px">
                    <div class="col-sm-4"><label>Tahun akademik baru</label><?= form_dropdown('tahun', $tahunOpsi, $tahun, ['class' => 'form-control', 'required' => 'required']) ?></div>
                    <div class="col-sm-8"><label>Keterangan</label><input type="text" name="keterangan" class="form-control" placeholder="Kenaikan kelas akhir tahun ajaran"></div>
                </div>
                <table class="table table-hover">
                    <thead><tr><th>Kelas Asal</th><th>Siswa Aktif</th><th style="width:40%">Tujuan</th></tr></thead>
                    <tbody>
                    <?php foreach ($kelas as $k): ?>
                        <tr>
                            <td><b><?= esc($k['kode_kelas']) ?></b> <small class="text-muted"><?= esc($k['nama_kelas']) ?></small></td>
                            <td><?= $k['jumlah'] ?> siswa</td>
                            <td><?= form_dropdown('peta[' . esc($k['kode_kelas'], 'attr') . ']', $opsi, $k['saran'], ['class' => 'form-control input-sm']) ?></td>
                        </tr>
                    <?php endforeach ?>
                    <?php if ($kelas === []): ?><tr><td colspan="3" class="text-center text-muted">Tidak ada kelas dengan siswa aktif.</td></tr><?php endif ?>
                    </tbody>
                </table>
            </div>
            <?php if (boleh_ubah()): ?>
                <div class="box-footer"><button type="submit" class="btn btn-primary">Lanjut ke Pratinjau <i class="fa fa-arrow-right"></i></button></div>
            <?php endif ?>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
