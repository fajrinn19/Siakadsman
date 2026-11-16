<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><i class="fa fa-users"></i> Akun Orang Tua</h3>
            <form class="pull-right filter-form" method="get" action="<?= site_url('akun-ortu') ?>">
                <?= form_dropdown('kelas', $kelasOpsi, $kelas, ['onchange' => 'this.form.submit()', 'aria-label' => 'Kelas']) ?>
            </form>
        </div>
        <div class="box-body table-responsive">
            <?php if ($kelas === ''): ?>
                <div class="pesan-kosong">Pilih kelas untuk melihat dan membuat akun orang tua.</div>
            <?php else: ?>
                <?php if (boleh_ubah()): ?>
                    <form method="post" action="<?= site_url('akun-ortu/buat') ?>" style="margin-bottom:12px">
                        <?= csrf_field() ?><input type="hidden" name="kelas" value="<?= esc($kelas, 'attr') ?>">
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-user-plus"></i> Buat akun untuk semua siswa yang belum punya</button>
                        <span class="text-muted" style="font-size:12px; margin-left:8px">Username: <code>ortu</code>+NISN · Password awal: NISN anak (wajib diganti saat login pertama)</span>
                    </form>
                <?php endif ?>
                <table class="table table-hover">
                    <thead><tr><th>No</th><th>Siswa</th><th>NISN</th><th>Nama Orang Tua</th><th>Username</th><th>No HP</th><th>Aksi</th></tr></thead>
                    <tbody>
                    <?php foreach ($siswa as $i => $s): ?>
                        <?php $a = $akun[$s['nisn']] ?? null; ?>
                        <tr>
                            <td><?= $i + 1 ?></td><td><?= esc($s['nama']) ?></td><td><?= esc($s['nisn']) ?></td>
                            <td><?= $a ? esc($a['nama']) : '<span class="text-muted">—</span>' ?></td>
                            <td><?= $a ? '<code>' . esc($a['username']) . '</code>' : '<span class="chip chip-redup">Belum ada</span>' ?></td>
                            <td><?= $a ? esc($a['no_hp']) : '' ?></td>
                            <td class="aksi">
                                <?php if (boleh_ubah()): ?>
                                    <?php if ($a): ?>
                                        <form method="post" action="<?= site_url('akun-ortu/reset/' . $a['id_ortu']) ?>" class="form-inline-btn" onsubmit="return confirm('Kembalikan password ke NISN anak?')"><?= csrf_field() ?><button class="btn btn-warning btn-xs" title="Reset password"><i class="fa fa-key"></i></button></form>
                                        <?= tombol_hapus(site_url('akun-ortu/hapus/' . $a['id_ortu']), 'Hapus akun orang tua ini?') ?>
                                    <?php else: ?>
                                        <form method="post" action="<?= site_url('akun-ortu/buat') ?>" class="form-inline-btn"><?= csrf_field() ?>
                                            <input type="hidden" name="kelas" value="<?= esc($kelas, 'attr') ?>"><input type="hidden" name="nisn" value="<?= esc($s['nisn'], 'attr') ?>">
                                            <button class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Buat</button></form>
                                    <?php endif ?>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
