<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-md-12">
    <div class="box box-info">
        <div class="box-header with-border"><h3 class="box-title">Siswa yang Mengirim Jawaban Tugas</h3>
            <a class="btn btn-default btn-sm pull-right" href="<?= site_url('bahan-tugas/' . $jadwal['kodejdwl']) ?>">Kembali</a></div>
        <div class="box-body">
            <?= view('components/info_jadwal', ['jadwal' => $jadwal, 'tambahan' => ['Nama Tugas' => $tugas['nama_file'], 'Terkumpul' => count($baris) . ' dari ' . $jumlahSiswa . ' siswa']]) ?>
            <table class="table table-bordered table-striped datatable">
                <thead><tr><th>No</th><th>NISN</th><th>Nama Siswa</th><th>Keterangan</th><th>Waktu Kirim</th><th>Aksi</th></tr></thead>
                <tbody>
                <?php foreach ($baris as $i => $r): ?>
                    <tr>
                        <td><?= $i + 1 ?></td><td class="text-red"><?= esc($r['nisn']) ?></td><td><?= esc($r['nama']) ?></td>
                        <td><?= nl2br(esc($r['keterangan'])) ?></td><td><?= esc($r['waktu']) ?> WIB</td>
                        <td><?php if ($r['file_tugas'] !== ''): ?><a class="btn btn-info btn-xs" href="<?= site_url('unduh/jawaban/' . $r['id_elearning_jawab']) ?>"><span class="glyphicon glyphicon-download"></span> Unduh</a><?php endif ?></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
