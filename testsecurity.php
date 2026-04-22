<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>TEST SECURITY - SQL Injection & XSS</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <style>
        body { padding: 20px; background: #f5f5f5; }
        .container { max-width: 900px; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .test-case { background: #f9f9f9; padding: 15px; margin-bottom: 15px; border-left: 4px solid #337ab7; border-radius: 5px; }
        .test-case h4 { color: #337ab7; margin-top: 0; }
        .code { background: #333; color: #0f0; padding: 10px; border-radius: 5px; font-family: monospace; margin: 10px 0; }
        .btn-copy { margin-left: 10px; }
        .warning { background: #f2dede; color: #a94442; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #ebccd1; }
        .safe { background: #dff0d8; color: #3c763d; padding: 15px; border-radius: 5px; margin-top: 20px; border: 1px solid #d6e9c6; }
    </style>
</head>
<body>
    <div class="container">
        <h2>🧪 TEST KEAMANAN LOGIN - SQL Injection & XSS</h2>
        <hr>
        
        <div class="warning">
            <strong>⚠️ PERHATIAN:</strong> File ini hanya untuk testing keamanan. 
            Pastikan sistem Anda sudah diamankan sebelum menjalankan test ini!
        </div>

        <!-- BAGIAN 1: SQL INJECTION TEST -->
        <h3>💉 1. SQL INJECTION TEST</h3>
        <p>Copy dan paste payload berikut ke field <strong>Username</strong> pada form login:</p>

        <div class="test-case">
            <h4>Test #1: Basic Authentication Bypass</h4>
            <p>Mencoba login tanpa password dengan memanipulasi query SQL</p>
            <div class="code" id="sqli1">' OR '1'='1</div>
            <button class="btn btn-sm btn-primary btn-copy" onclick="copyText('sqli1')">📋 Copy</button>
        </div>

        <div class="test-case">
            <h4>Test #2: Comment Injection</h4>
            <p>Menggunakan komentar SQL untuk mengabaikan pengecekan password</p>
            <div class="code" id="sqli2">admin' -- </div>
            <button class="btn btn-sm btn-primary btn-copy" onclick="copyText('sqli2')">📋 Copy</button>
        </div>

        <div class="test-case">
            <h4>Test #3: Union Based Injection</h4>
            <p>Mencoba mengambil data dari tabel lain</p>
            <div class="code" id="sqli3">' UNION SELECT * FROM rb_users -- </div>
            <button class="btn btn-sm btn-primary btn-copy" onclick="copyText('sqli3')">📋 Copy</button>
        </div>

        <div class="test-case">
            <h4>Test #4: Stacked Query</h4>
            <p>Mencoba menjalankan multiple query</p>
            <div class="code" id="sqli4">'; DROP TABLE rb_users; -- </div>
            <button class="btn btn-sm btn-primary btn-copy" onclick="copyText('sqli4')">📋 Copy</button>
        </div>

        <div class="test-case">
            <h4>Test #5: Boolean Blind</h4>
            <p>Mencoba menebak data dengan kondisi true/false</p>
            <div class="code" id="sqli5">admin' AND '1'='1</div>
            <button class="btn btn-sm btn-primary btn-copy" onclick="copyText('sqli5')">📋 Copy</button>
        </div>

        <!-- BAGIAN 2: XSS TEST -->
        <h3 style="margin-top: 30px;">🎯 2. XSS (Cross-Site Scripting) TEST</h3>
        <p>Copy dan paste payload berikut ke field <strong>Username</strong> atau <strong>CAPTCHA</strong>:</p>

        <div class="test-case">
            <h4>Test #6: Basic XSS Alert</h4>
            <p>Mencoba menampilkan popup alert</p>
            <div class="code" id="xss1"><script>alert('XSS')</script></div>
            <button class="btn btn-sm btn-primary btn-copy" onclick="copyText('xss1')">📋 Copy</button>
        </div>

        <div class="test-case">
            <h4>Test #7: IMG Tag XSS</h4>
            <p>Menggunakan tag gambar untuk eksekusi JavaScript</p>
            <div class="code" id="xss2"><img src=x onerror=alert('XSS')></div>
            <button class="btn btn-sm btn-primary btn-copy" onclick="copyText('xss2')">📋 Copy</button>
        </div>

        <div class="test-case">
            <h4>Test #8: SVG XSS</h4>
            <p>Menggunakan tag SVG</p>
            <div class="code" id="xss3"><svg/onload=alert('XSS')></div>
            <button class="btn btn-sm btn-primary btn-copy" onclick="copyText('xss3')">📋 Copy</button>
        </div>

        <div class="test-case">
            <h4>Test #9: Event Handler XSS</h4>
            <p>Menggunakan event handler HTML</p>
            <div class="code" id="xss4"><body onload=alert('XSS')></div>
            <button class="btn btn-sm btn-primary btn-copy" onclick="copyText('xss4')">📋 Copy</button>
        </div>

        <div class="test-case">
            <h4>Test #10: Encoded XSS</h4>
            <p>XSS dengan encoding karakter</p>
            <div class="code" id="xss5">&lt;script&gt;alert('XSS')&lt;/script&gt;</div>
            <button class="btn btn-sm btn-primary btn-copy" onclick="copyText('xss5')">📋 Copy</button>
        </div>

        <!-- BAGIAN 3: CAPTCHA BYPASS TEST -->
        <h3 style="margin-top: 30px;">🤖 3. CAPTCHA BYPASS TEST</h3>

        <div class="test-case">
            <h4>Test #11: CAPTCHA SQL Injection</h4>
            <p>Mencoba injeksi SQL pada field CAPTCHA</p>
            <div class="code" id="captcha1">' OR '1'='1</div>
            <button class="btn btn-sm btn-primary btn-copy" onclick="copyText('captcha1')">📋 Copy</button>
        </div>

        <div class="test-case">
            <h4>Test #12: CAPTCHA XSS</h4>
            <p>Mencoba XSS pada field CAPTCHA</p>
            <div class="code" id="captcha2"><script>alert('CAPTCHA Bypass')</script></div>
            <button class="btn btn-sm btn-primary btn-copy" onclick="copyText('captcha2')">📋 Copy</button>
        </div>

        <!-- HASIL YANG DIHARAPKAN -->
        <div class="safe">
            <strong>✅ HASIL YANG DIHARAPKAN (Jika Sistem AMAN):</strong>
            <ul style="margin-top: 10px;">
                <li>Semua payload SQL Injection akan <strong>GAGAL</strong> login</li>
                <li>Semua payload XSS akan <strong>DIBERSIHKAN</strong> (tidak muncul alert)</li>
                <li>CAPTCHA tetap berfungsi normal</li>
                <li>Tidak ada data yang rusak atau hilang</li>
                <li>Limitasi login tetap berjalan</li>
            </ul>
        </div>

        <hr>
        <p style="text-align: center;">
            <a href="index.php?view=login" class="btn btn-primary btn-lg">🔐 Kembali ke Login</a>
            <a href="check_security.php" class="btn btn-success btn-lg">📊 Cek Hasil Test</a>
        </p>
    </div>

    <script>
        function copyText(elementId) {
            var text = document.getElementById(elementId).innerText;
            navigator.clipboard.writeText(text).then(function() {
                alert('✅ Payload berhasil dicopy!');
            });
        }
    </script>
</body>
</html>