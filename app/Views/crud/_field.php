<?php
/**
 * Satu baris input form.
 *
 * @var array<string, mixed> $f
 * @var array<string, mixed> $row
 * @var bool                 $baru
 * @var string|null          $form  id form tujuan (atribut form="...") bila input berada di luar tag <form>
 */
$nama  = $f['name'];
$tipe  = $f['type'] ?? 'text';
$nilai = old($nama, $row[$nama] ?? ($f['default'] ?? ''));
$attr  = ['class' => 'form-control', 'id' => 'f_' . $nama];
if (! empty($form)) {
    $attr['form'] = $form;
}
if (! empty($f['placeholder'])) {
    $attr['placeholder'] = $f['placeholder'];
}
if (! empty($f['readonly'])) {
    $attr['readonly'] = 'readonly';
}
if (str_contains($f['rules'] ?? '', 'required') && $tipe !== 'radio') {
    $attr['required'] = 'required';
}
?>
<tr<?= ! empty($f['separator']) ? ' style="background:#e3e3e3"' : '' ?>>
    <th style="width:170px" scope="row"><label for="f_<?= esc($nama, 'attr') ?>"><?= esc($f['label']) ?></label></th>
    <td>
        <?php switch ($tipe):
            case 'textarea': ?>
                <?= form_textarea(['name' => $nama, 'rows' => $f['rows'] ?? 4] + $attr, (string) $nilai) ?>
                <?php break ?>
            <?php case 'select': ?>
                <?= form_dropdown($nama, $f['options'], (string) $nilai, $attr) ?>
                <?php break ?>
            <?php case 'radio': ?>
                <?php foreach ($f['options'] as $v => $label): ?>
                    <label style="font-weight:normal; margin-right:15px">
                        <?= form_radio($nama, (string) $v, (string) $nilai === (string) $v || ((string) $nilai === '' && (string) $v === (string) array_key_first($f['options'])), ! empty($form) ? ['form' => $form] : []) ?> <?= esc($label) ?>
                    </label>
                <?php endforeach ?>
                <?php break ?>
            <?php case 'password': ?>
                <?= form_password(['name' => $nama, 'autocomplete' => 'new-password'] + $attr + ['placeholder' => $baru ? '' : 'Kosongkan jika password tidak diganti']) ?>
                <?php break ?>
            <?php case 'static': ?>
                <p class="form-control-static"><?= esc((string) $nilai) ?></p>
                <?php break ?>
            <?php default: ?>
                <?= form_input(['name' => $nama, 'type' => $tipe] + $attr, (string) $nilai) ?>
        <?php endswitch ?>
        <?php if (! empty($f['help'])): ?><span class="help-block"><?= esc($f['help']) ?></span><?php endif ?>
    </td>
</tr>
