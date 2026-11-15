<?php /** Filter tahun akademik + kelas untuk halaman raport. */ ?>
<form class="pull-right filter-form" method="get" action="<?= site_url($segmen) ?>">
    <?= form_dropdown('tahun', $tahunOpsi, $tahun) ?>
    <?= form_dropdown('kelas', $kelasOpsi, $kelas) ?>
    <button type="submit" class="btn btn-info btn-sm">Lihat</button>
</form>
