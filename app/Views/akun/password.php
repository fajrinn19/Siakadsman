<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-md-6 col-md-offset-3">
    <div class="box">
        <div class="box-header with-border"><h3 class="box-title"><i class="fa fa-key"></i> Ganti Password</h3></div>
        <form method="post" action="<?= site_url('akun/password') ?>">
            <?= csrf_field() ?>
            <div class="box-body">
                <?php if ($wajib): ?>
                    <div class="alert alert-warning"><b>Demi keamanan akun,</b> password Anda masih sama dengan username/NIP/NISN. Silakan buat password baru sebelum melanjutkan.</div>
                <?php endif ?>
                <div class="form-group"><label for="pl">Password lama</label><input type="password" class="form-control" id="pl" name="password_lama" required autocomplete="current-password"></div>
                <div class="form-group"><label for="pb">Password baru</label><input type="password" class="form-control" id="pb" name="password_baru" minlength="6" required autocomplete="new-password"><span class="help-block">Minimal 6 karakter, tidak sama dengan username.</span></div>
                <div class="form-group"><label for="pk">Ulangi password baru</label><input type="password" class="form-control" id="pk" name="konfirmasi" minlength="6" required autocomplete="new-password"></div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Simpan Password</button>
                <?php if ($wajib): ?><a href="<?= site_url('logout') ?>" class="btn btn-default pull-right">Logout</a><?php endif ?>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
