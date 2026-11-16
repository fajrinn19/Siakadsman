<div class="box">
    <div class="box-header"><h3 class="box-title"><i class="fa fa-files-o"></i> <?= esc($judulBox) ?></h3>
        <?php if (! empty($semua)): ?><a href="<?= site_url('ortu/tugas') ?>" class="pull-right" style="font-size:12px">Lihat semua</a><?php endif ?></div>
    <div class="box-body table-responsive">
        <table class="table table-hover" style="margin-bottom:0">
            <thead><tr><th>Mata Pelajaran</th><th>Tugas</th><th>Batas Waktu</th><th>Status</th></tr></thead>
            <tbody>
            <?php foreach ($tugas as $t): ?>
                <tr><td><?= esc($t['namamatapelajaran']) ?></td><td><?= esc($t['nama_file']) ?></td>
                    <td><?= tgl_valid($t['tanggal_selesai']) ? esc(substr($t['tanggal_selesai'], 0, 16)) : '-' ?></td>
                    <td><?php if ($t['dikirim']): ?><span class="chip chip-aktif">Sudah dikirim</span>
                        <?php elseif ($t['habis']): ?><span class="chip chip-tunggu" style="background:#fde9e3;color:#a5402a">Tidak dikirim</span>
                        <?php else: ?><span class="chip chip-tunggu">Belum dikirim</span><?php endif ?></td></tr>
            <?php endforeach ?>
            <?php if ($tugas === []): ?><tr><td colspan="4" class="text-center text-muted">Belum ada tugas.</td></tr><?php endif ?>
            </tbody>
        </table>
    </div>
</div>
