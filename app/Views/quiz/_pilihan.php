<?php
/**
 * Pilihan jawaban soal objektif.
 *
 * @var array       $soal
 * @var string|null $nama   nama input radio (null = hanya tampil)
 */
foreach (['a', 'b', 'c', 'd', 'e'] as $h):
    $teks = trim((string) $soal['jawab_' . $h]);
    if ($teks === '') {
        continue;
    }
    $dipilih = ($soal['jawaban'] ?? '') === $h;
    $kunci   = ! empty($tampilKunci) && strtolower((string) $soal['kunci_jawaban']) === $h;
?>
    <div class="radio" style="margin:2px 0<?= $kunci ? ';font-weight:bold' : '' ?>">
        <label>
            <input type="radio" <?= $nama ? 'name="' . esc($nama, 'attr') . '"' : 'disabled' ?> value="<?= $h ?>"<?= $dipilih ? ' checked' : '' ?>>
            <?= $h ?>. <?= esc($teks) ?><?= $kunci ? ' <span class="text-green">(kunci)</span>' : '' ?>
        </label>
    </div>
<?php endforeach ?>
