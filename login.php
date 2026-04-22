<?php
session_start();

// ============= FUNGSI LIMITASI LOGIN =============
function get_client_ip() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

function cek_limitasi_login($ip) {
    mysql_query("DELETE FROM login_attempts WHERE attempt_time < DATE_SUB(NOW(), INTERVAL 15 MINUTE)");
    $query = "SELECT COUNT(*) as total FROM login_attempts WHERE ip_address = '".mysql_real_escape_string($ip)."'";
    $result = mysql_query($query);
    $data = mysql_fetch_assoc($result);
    return $data['total'];
}

function catat_login_gagal($ip, $username) {
    mysql_query("INSERT INTO login_attempts (ip_address, username, attempt_time) 
                 VALUES ('".mysql_real_escape_string($ip)."', '".mysql_real_escape_string($username)."', NOW())");
}

function hapus_catatan_login($ip) {
    mysql_query("DELETE FROM login_attempts WHERE ip_address = '".mysql_real_escape_string($ip)."'");
}

// ============= FUNGSI BARU: HITUNG SISA WAKTU BLOKIR =============
function get_sisa_waktu_blokir($ip) {
    $query = "SELECT attempt_time FROM login_attempts 
              WHERE ip_address = '".mysql_real_escape_string($ip)."' 
              AND attempt_time > DATE_SUB(NOW(), INTERVAL 15 MINUTE)
              ORDER BY attempt_time DESC LIMIT 1";
    $result = mysql_query($query);
    
    if (mysql_num_rows($result) > 0) {
        $data = mysql_fetch_assoc($result);
        $first_attempt = strtotime($data['attempt_time']);
        $unblock_time = $first_attempt + (5 * 60); // 15 menit dari percobaan pertama
        $current_time = time();
        $sisa_detik = $unblock_time - $current_time;
        
        if ($sisa_detik > 0) {
            return $sisa_detik;
        }
    }
    return 0;
}

function format_waktu($detik) {
    $menit = floor($detik / 60);
    $detik_sisa = $detik % 60;
    return $menit . " menit " . $detik_sisa . " detik";
}

// ============= GENERATE CAPTCHA =============
if (!isset($_SESSION['captcha_code'])) {
    $_SESSION['captcha_code'] = substr(strtoupper(md5(rand())), 0, 6);
}

// ============= CEK STATUS BLOKIR UNTUK DITAMPILKAN =============
$ip = get_client_ip();
$is_blocked = false;
$sisa_waktu = 0;
$sisa_waktu_text = '';

$percobaan = cek_limitasi_login($ip);
if ($percobaan >= 5) {
    $is_blocked = true;
    $sisa_waktu = get_sisa_waktu_blokir($ip);
    $sisa_waktu_text = format_waktu($sisa_waktu);
}

// ============= PROSES LOGIN =============
if (isset($_POST['login'])) {
    $ip = get_client_ip();
    $username_input = anti_injection($_POST['a']);
    
    // CEK LIMITASI LOGIN
    $percobaan = cek_limitasi_login($ip);
    if ($percobaan >= 5) {
        $sisa = get_sisa_waktu_blokir($ip);
        $waktu_text = format_waktu($sisa);
        echo "<script>alert('Anda telah melebihi batas percobaan login. Silakan coba lagi dalam ".$waktu_text.".'); window.location=('index.php?view=login');</script>";
        exit();
    }
    
    // CEK CAPTCHA (DENGAN PENCEGAHAN XSS & SQL INJECTION)
    $captcha_input = isset($_POST['captcha']) ? trim(strip_tags(htmlspecialchars($_POST['captcha'], ENT_QUOTES, 'UTF-8'))) : '';
    if (empty($captcha_input) || strtoupper($captcha_input) != $_SESSION['captcha_code']) {
        catat_login_gagal($ip, $username_input);
        $_SESSION['captcha_code'] = substr(strtoupper(md5(rand())), 0, 6);
        $sisa = 5 - cek_limitasi_login($ip);
        echo "<script>alert('Kode CAPTCHA salah! Sisa percobaan: ".$sisa."'); window.location=('index.php?view=login');</script>";
        exit();
    }
    
    // KODE ASLI (TIDAK DIUBAH)
    $passlain = anti_injection($_POST['b']);
    $data = md5(anti_injection($_POST['b']));
    $pass = hash("sha512", $data);
    $admin = mysql_query("SELECT * FROM rb_users WHERE username='".anti_injection($_POST['a'])."' AND password='$pass'");
    $guru = mysql_query("SELECT * FROM rb_guru WHERE nip='".anti_injection($_POST['a'])."' AND password='$passlain'");
    $siswa = mysql_query("SELECT * FROM rb_siswa WHERE nisn='".anti_injection($_POST['a'])."' AND password='$passlain'");
    
    $hitungadmin = mysql_num_rows($admin);
    $hitungguru = mysql_num_rows($guru);
    $hitungsiswa = mysql_num_rows($siswa);
    
    if ($hitungadmin >= 1) {
        hapus_catatan_login($ip);
        unset($_SESSION['captcha_code']);
        
        $r = mysql_fetch_array($admin);
        $_SESSION['id'] = $r['id_user'];
        $_SESSION['namalengkap'] = $r['nama_lengkap'];
        $_SESSION['level'] = $r['level'];
        include "config/user_agent.php";
        mysql_query("INSERT INTO rb_users_aktivitas VALUES('','$r[id_user]','$ip','$user_browser $version','$user_os','$r[level]','".date('H:i:s')."','".date('Y-m-d')."')");
        echo "<script>document.location='index.php';</script>";
    } elseif ($hitungguru >= 1) {
        hapus_catatan_login($ip);
        unset($_SESSION['captcha_code']);
        
        $r = mysql_fetch_array($guru);
        $_SESSION['id'] = $r['nip'];
        $_SESSION['namalengkap'] = $r['nama_guru'];
        $_SESSION['level'] = 'guru';
        include "config/user_agent.php";
        mysql_query("INSERT INTO rb_users_aktivitas VALUES('','$r[nip]','$ip','$user_browser $version','$user_os','guru','".date('H:i:s')."','".date('Y-m-d')."')");
        echo "<script>document.location='index.php';</script>";
    } elseif ($hitungsiswa >= 1) {
        hapus_catatan_login($ip);
        unset($_SESSION['captcha_code']);
        
        $r = mysql_fetch_array($siswa);
        $_SESSION['id'] = $r['nisn'];
        $_SESSION['namalengkap'] = $r['nama'];
        $_SESSION['kode_kelas'] = $r['kode_kelas'];
        $_SESSION['angkatan'] = $r['angkatan'];
        $_SESSION['level'] = 'siswa';
        include "config/user_agent.php";
        mysql_query("INSERT INTO rb_users_aktivitas VALUES('','$r[nisn]','$ip','$user_browser $version','$user_os','siswa','".date('H:i:s')."','".date('Y-m-d')."')");
        echo "<script>document.location='index.php';</script>";
    } else {
        catat_login_gagal($ip, $username_input);
        $_SESSION['captcha_code'] = substr(strtoupper(md5(rand())), 0, 6);
        $sisa = 5 - cek_limitasi_login($ip);
        echo "<script>window.alert('Maaf, Username atau Password salah! Sisa percobaan: ".$sisa."'); window.location=('index.php?view=login');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SISFO Akademik | Log in</title>
    <meta name="author" content="phpmu.com">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

    <style>
      #a { border-radius: 30px; margin-top: 4px; color: black; }
      #b { border-radius: 30px; margin-top: 4px; margin-bottom: 1px; color: black; }
      #c { border-radius: 30px; margin-top: 30px; color: black; }
      #d { border-radius: 40px; margin-top: 5px; color: green; }
      .form-signin { background: #ADD8E6; border-radius: 30px; }
      .captcha-box {
        background: #f0f0f0; padding: 8px; border-radius: 10px; margin-bottom: 10px;
        font-family: monospace; font-size: 22px; letter-spacing: 5px; text-align: center;
        font-weight: bold; color: #333; border: 2px dashed #999; position: relative;
      }
      .refresh-captcha {
        cursor: pointer; color: #337ab7; margin-left: 10px; font-size: 18px;
        position: absolute; right: 10px; top: 8px;
      }
      /* STYLE UNTUK NOTIFIKASI BLOKIR */
      .blocked-notice {
        background: #f2dede;
        color: #a94442;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        border: 1px solid #ebccd1;
        text-align: center;
      }
      .blocked-notice .timer {
        font-size: 24px;
        font-weight: bold;
        margin: 10px 0;
      }
      .warning-notice {
        background: #fcf8e3;
        color: #8a6d3b;
        padding: 10px;
        border-radius: 10px;
        margin-bottom: 15px;
        border: 1px solid #faebcc;
        font-size: 14px;
      }
    </style>
  </head>
  <body class="text-center" style="background-image: url('dist/img/sinjai2.png');">
    <div class="login-box">
      <div class="login-logo">
        <a href="../../index2.html" style="color: white"><b>SISTEM INFORMASI</b> AKADEMIK</a>
      </div>

      <div style="border-radius: 20px" class="login-box-body">
        <h3><p class="mt-5 mb-3 text-muted"><b style="color: blue;">SMA NEGERI 14 SINJAI</b></p></h3>
        <p class="login-box-msg"><h5>Masukan Username dan Password!</h5></p>
        
        <!-- NOTIFIKASI JIKA TERBLOKIR -->
        <?php if ($is_blocked): ?>
        <div class="blocked-notice" id="blockedNotice">
            <i class="fa fa-lock" style="font-size: 30px;"></i>
            <h4><strong>AKSES DIBLOKIR SEMENTARA</strong></h4>
            <p>Anda telah melebihi batas percobaan login (5x).</p>
            <p>Silakan coba lagi dalam:</p>
            <div class="timer" id="countdownTimer">
                <?php echo $sisa_waktu_text; ?>
            </div>
            <small>Halaman akan otomatis refresh setelah waktu habis.</small>
        </div>
        <script>
            // COUNTDOWN TIMER
            var sisaDetik = <?php echo $sisa_waktu; ?>;
            var timerElement = document.getElementById('countdownTimer');
            
            function updateTimer() {
                if (sisaDetik <= 0) {
                    timerElement.innerHTML = '0 menit 0 detik';
                    location.reload();
                    return;
                }
                
                var menit = Math.floor(sisaDetik / 60);
                var detik = sisaDetik % 60;
                timerElement.innerHTML = menit + ' menit ' + detik + ' detik';
                sisaDetik--;
                setTimeout(updateTimer, 1000);
            }
            
            // Mulai countdown
            updateTimer();
        </script>
        <?php endif; ?>
        
        <!-- NOTIFIKASI SISA PERCOBAAN -->
        <?php if (!$is_blocked && $percobaan > 0): ?>
        <div class="warning-notice">
            <i class="fa fa-exclamation-triangle"></i>
            <strong>Sisa percobaan login: <?php echo (5 - $percobaan); ?> kali lagi</strong>
        </div>
        <?php endif; ?>

        <?php if (!$is_blocked): ?>
        <form action="" method="post">
          <div class="form-group has-feedback">
            <input style="border-radius: 10px" type="text" class="form-control" name='a' placeholder="Username" required>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input style="border-radius: 10px" type="password" class="form-control" name='b' placeholder="Password" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          
          <!-- CAPTCHA -->
          <div class="form-group">
            <div class="captcha-box">
              <?php echo htmlspecialchars($_SESSION['captcha_code'], ENT_QUOTES, 'UTF-8'); ?>
              <span class="refresh-captcha" onclick="refreshCaptcha()">
                <i class="fa fa-refresh"></i>
              </span>
            </div>
            <input style="border-radius: 10px" type="text" class="form-control" name='captcha' placeholder="Masukkan kode verifikasi" required maxlength="6" autocomplete="off">
          </div>
          
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label><input type="checkbox"> Remember Me</label>
              </div>
            </div>
            <div class="col-xs-4">
              <button name='login' type="submit" style="border-radius: 10px" class="btn btn-lg btn-primary btn-block">Login</button>
            </div>
          </div>
        
          <marquee><p class="mt-5 mb-3 text-muted"><b style="color: blue;">SISTEM INFORMASI AKADEMIK SMA NEGERI 14 SINJAI | <?php echo date('d-m-Y'); ?></b></p></marquee>
        </form>
        <?php endif; ?>
      </div>
    </div>

    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%'
        });
      });
      
      function refreshCaptcha() {
        $.ajax({
          url: 'refresh_captcha.php',
          cache: false,
          success: function(data) {
            $('.captcha-box').html(data + ' <span class="refresh-captcha" onclick="refreshCaptcha()"><i class="fa fa-refresh"></i></span>');
          }
        });
      }
    </script>
  </body>
</html>