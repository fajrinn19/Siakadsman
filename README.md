# SIAKAD SMA — Sistem Informasi Akademik

Sistem informasi akademik sekolah (SMA Negeri 14 Sinjai) berbasis **CodeIgniter 4.7** dan **PHP 8.2+**,
dengan tampilan AdminLTE 2.

Fitur untuk lima jenis pengguna:

| Pengguna | Fitur |
| --- | --- |
| **Administrator** | Data master, data siswa/guru/admin, **impor siswa dari Excel**, **akun orang tua**, absensi siswa & guru, journal KBM, e-learning, quiz (**bank soal**), forum, nilai UTS & raport, capaian sikap, ekstrakurikuler, prestasi, cetak raport (**PDF per siswa / satu kelas, format K13 & Merdeka**), **ekspor nilai/absensi ke Excel**, **riwayat kelas**, **wizard kenaikan kelas & data alumni**, **PPDB**, **pengumuman & kalender akademik**, **notifikasi WhatsApp**, **pemeriksaan data**, **log aktivitas** |
| **Kepala Sekolah** | Melihat data siswa, guru, kelas, jadwal, absensi, journal, forum, raport, alumni, dan PPDB (hanya-baca) |
| **Guru** | Jadwal mengajar, bahan & tugas, quiz (acak soal, bank soal, kirim nilai ke raport), absensi siswa + rekap bulanan + ekspor Excel, forum, kompetensi dasar, journal KBM, input nilai UTS & raport, cetak raport |
| **Siswa** | Jadwal, bahan & tugas (kirim jawaban), quiz online (timer otomatis), penilaian diri & teman, forum, nilai UTS & raport (termasuk kelas tahun lalu), pengumuman, kalender |
| **Orang Tua** | Portal orang tua: profil anak, absensi, status tugas, nilai UTS & raport, pengumuman, kalender |

Halaman publik tanpa login: **formulir PPDB** (`/ppdb`) dan cek status pendaftaran (`/ppdb/status`).

## Persyaratan

- PHP **8.2** atau lebih baru dengan ekstensi `intl`, `mbstring`, `mysqli`, `gd` (untuk validasi foto), `curl`
- MySQL 5.7+ / MariaDB 10.3+
- Composer 2

## Instalasi (lokal)

```bash
git clone https://github.com/fajrinn19/Siakadsman.git
cd Siakadsman
composer install
cp env .env
```

1. Buat database, misalnya `siakad-st`, lalu impor `database/siakad-st.sql`.
2. Ubah `.env`:

   ```ini
   CI_ENVIRONMENT = production
   app.baseURL = 'http://localhost:8080/'

   database.default.hostname = localhost
   database.default.database = siakad-st
   database.default.username = root
   database.default.password =
   database.default.DBDriver = MySQLi
   ```

3. Jalankan migrasi (menambah tabel riwayat kelas, akun orang tua, pengumuman, kalender, log aktivitas,
   dan mengubah tabel lama ke InnoDB). Aman dijalankan berulang:

   ```bash
   php spark migrate
   ```

4. Jalankan:

   ```bash
   php spark serve
   ```

   lalu buka <http://localhost:8080>.

## Instalasi di hosting

1. Upload seluruh isi proyek (termasuk folder `vendor` hasil `composer install --no-dev`).
2. Arahkan **document root** domain/subdomain ke folder `public/`.
   Jika tidak bisa mengubah document root, upload isi `public/` ke `public_html/`
   dan sesuaikan path di `public_html/index.php` (`FCPATH . '../app/Config/Paths.php'`).
3. Buat database lewat cPanel, impor `database/siakad-st.sql`, dan isi `.env` seperti di atas
   (`app.baseURL` diisi alamat domain, contoh `https://siakad.sekolah.sch.id/`).
4. Pastikan folder `writable/` dan `public/uploads/` bisa ditulis oleh web server.

## Pengaturan sekolah

Nama sekolah, kota, nama & NIP kepala sekolah (untuk tanda tangan raport), KKM, serta notifikasi SMS
ada di `app/Config/Sekolah.php` dan bisa ditimpa lewat `.env`:

```ini
sekolah.nama = 'SMA NEGERI 14 SINJAI'
sekolah.kepalaNama = 'Nama Kepala Sekolah, S.Pd.'
sekolah.kepalaNip = '19xxxxxxxxxxxxxxx'
sekolah.kkm = 77
```

## Notifikasi WhatsApp (opsional)

Absensi siswa yang tidak hadir masuk antrean pesan ke orang tua. Untuk mengirimnya lewat WhatsApp:

1. Daftar di [fonnte.com](https://fonnte.com) dan hubungkan nomor WhatsApp sekolah.
2. Isi `notifikasi.token = 'TOKEN_ANDA'` di `.env`.
3. Kirim dari menu **Informasi → Notifikasi WhatsApp**, atau otomatis lewat cron:

   ```bash
   */5 * * * * cd /path/ke/siakad && php spark notifikasi:kirim
   ```

## Login

Satu form login untuk semua pengguna:

- **Admin / Kepala Sekolah**: username dari tabel `rb_users`
- **Guru**: NIP
- **Siswa**: NISN
- **Orang tua**: `ortu` + NISN anak (akun dibuat admin di menu **Data Pengguna → Akun Orang Tua**)

Akun yang password-nya masih sama dengan username/NIP/NISN (termasuk akun orang tua baru) **wajib mengganti
password** saat login pertama. Semua pengguna bisa mengganti password lewat menu **Ganti Password**.

Password lama dari aplikasi sebelumnya tetap bisa dipakai. Saat pengguna berhasil login, password
otomatis diubah ke format aman (`password_hash` / bcrypt).

## Struktur proyek

```
app/
  Config/Routes.php        Semua URL & pembatasan akses per level
  Config/Menu.php          Menu sidebar per level
  Config/Sekolah.php       Identitas sekolah untuk raport
  Controllers/
    Master/CrudController  CRUD generik untuk data master
    Master/*               Gedung, Kelas, Mata Pelajaran, Jadwal, Admin, dll.
    Raport/*               Capaian, Ekstrakurikuler, Prestasi, Cetak, Raport Siswa
    *.php                  Siswa, Guru, Absensi, Journal, BahanTugas, Quiz, Forum, Nilai, ...
  Filters/                 AuthFilter (wajib login), RoleFilter (level pengguna)
  Helpers/siakad_helper    Tanggal Indonesia, sesi pengguna, tombol hapus
  Libraries/               Password (kompatibel data lama), Raport (rumus nilai), DataRaport
  Models/                  Satu model per tabel
  Views/                   layouts, partials, crud, components, dan view per modul
database/siakad-st.sql     Struktur & data awal
public/                    index.php, aset (bootstrap, dist, plugins), uploads (foto)
writable/uploads/tugas     File bahan/tugas & jawaban siswa (tidak bisa diakses langsung)
tests/                     Unit test (composer test)
```

## Perubahan dari versi lama (PHP native)

- Dipindah ke **CodeIgniter 4** (MVC, routing, Query Builder) dan berjalan di **PHP 8.2+**.
  Versi lama memakai `mysql_*` dan sintaks `$_GET[view]` yang error di PHP 8.
- **Keamanan**: semua query memakai Query Builder (bebas SQL injection), output di-escape (XSS),
  CSRF di semua form, hapus data lewat POST, pembatasan akses di server (bukan redirect JavaScript),
  guru hanya bisa membuka jadwal yang diampu dan siswa hanya jadwal kelasnya, password di-hash,
  unduhan file dicek hak aksesnya (tidak bisa lagi `download.php?file=../...`).
- **Perbaikan bug**: update absensi siswa dulu menimpa absensi di semua tanggal; edit golongan &
  jenis PTK menyimpan ke kolom yang salah; status aktif gedung tidak cocok dengan tipe kolom;
  ketidakhadiran di raport kini dihitung dari absensi (dulu selalu 0); rekap absensi bulanan guru
  yang dulu memakai tabel yang tidak ada kini berfungsi.
- **Fitur baru — Riwayat kelas siswa**: setiap siswa ditambahkan, naik, pindah, atau tinggal kelas
  tercatat (kelas asal → tujuan, tahun akademik, keterangan, pencatat) dan tampil di tab "Riwayat Kelas"
  pada detail siswa. Daftar siswa di halaman raport kelas lama tetap memuat siswa yang sudah naik kelas,
  sehingga raport semester sebelumnya masih bisa diisi dan dicetak.
- **Fitur tambahan**: wizard kenaikan kelas (X→XI→XII→Lulus) dengan pratinjau & pengecualian tinggal kelas,
  data alumni, portal orang tua, PPDB online, impor siswa Excel, ekspor nilai/absensi Excel, raport PDF
  (K13 & Kurikulum Merdeka), quiz dengan acak soal + timer otomatis + bank soal + kirim nilai ke raport,
  cek jadwal bentrok (guru/ruangan/kelas), pengumuman & kalender akademik, notifikasi WhatsApp,
  pemeriksaan data (data yatim, aktif ganda), log aktivitas, wajib ganti password bawaan, nama kepala
  sekolah di raport diambil dari akun kepala sekolah, hanya satu tahun akademik & kurikulum yang aktif.
- **Pengujian**: unit test + feature test akses per level; berjalan otomatis di GitHub Actions.
- Kode berulang dirapikan: 15 modul master memakai satu `CrudController`, halaman "pilih jadwal"
  dipakai bersama oleh 9 modul, dan rumus nilai raport ada di satu tempat (`App\Libraries\Raport`).
