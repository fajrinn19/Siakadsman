<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title><?= esc($judul ?? 'Cetak') ?></title>
    <link rel="stylesheet" href="<?= base_url('bootstrap/css/printer.css') ?>">
    <style>
        body { font-family: Arial, sans-serif; }
        table.garis { border-collapse: collapse; }
        table.garis th, table.garis td { border: 1px solid #000; padding: 4px; }
        .ttd td { vertical-align: top; }
        @media print { .no-print { display: none; } }
    </style>
    <?= $this->renderSection('head') ?>
</head>
<body onload="window.print()">
<?= $this->renderSection('content') ?>
</body>
</html>
