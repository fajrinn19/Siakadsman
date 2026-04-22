<?php
include "parser-php-version.php";
date_default_timezone_set('Asia/Jakarta');

$server = "localhost";
$username = "root";
$password = "";
$database = "siakad-st";

$conn = mysql_connect($server, $username, $password);
mysql_select_db($database);

echo "<h3>📝 MEMBUAT TABEL login_attempts</h3>";

$sql = "CREATE TABLE IF NOT EXISTS `login_attempts` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `ip_address` varchar(45) NOT NULL,
    `username` varchar(100) NOT NULL,
    `attempt_time` datetime NOT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_ip` (`ip_address`),
    KEY `idx_time` (`attempt_time`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";

if (mysql_query($sql)) {
    echo "✅ Tabel 'login_attempts' BERHASIL dibuat!<br>";
    
    // Verifikasi
    $cek = mysql_query("SHOW TABLES LIKE 'login_attempts'");
    if (mysql_num_rows($cek) > 0) {
        echo "✅ Verifikasi: Tabel sudah ada di database!";
    }
} else {
    echo "❌ GAGAL: " . mysql_error();
}

mysql_close($conn);
?>