<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-md-12">
    <div class="box box-info">
        <div class="box-header with-border"><h3 class="box-title">Kirim Tugas: <?= esc($tugas['nama_file']) ?></h3></div>
        <form method="post" action="<?= site_url('bahan-tugas/' . $jadwal['kodejdwl'] . '/kirim/' . $tugas['id_elearning']) ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="box-body">
                <?= view('components/info_jadwal', ['jadwal' => $jadwal, 'tambahan' => ['Batas Waktu' => tgl_valid($tugas['tanggal_selesai']) ? substr($tugas['tanggal_selesai'], 0, 16) . ' WIB' : '-']]) ?>
                <div class="form-group"><label>File Tugas</label><input type="file" name="file" required><span class="help-block">Maksimal 10 MB.</span></div>
                <div class="form-group"><label>Keterangan</label><textarea rows="4" class="form-control" name="keterangan"><?= esc(old('keterangan')) ?></textarea></div>
                <p><i><b class="text-red">Catatan</b>: Tugas hanya bisa dikirimkan 1 (satu) kali.</i></p>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-info">Kirimkan Tugas</button>
                <a href="<?= site_url('bahan-tugas/' . $jadwal['kodejdwl']) ?>" class="btn btn-default pull-right">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
