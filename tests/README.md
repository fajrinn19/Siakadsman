# Pengujian

- `tests/unit` — logika inti tanpa database (password lama, rumus raport, helper tanggal).
- `tests/feature` — akses halaman per level pengguna; butuh database MySQL/MariaDB berisi
  `database/siakad-st.sql` (dilewati otomatis jika database uji tidak tersedia).

Menjalankan semua test dengan database uji terpisah:

```bash
mysql -uroot -e "CREATE DATABASE siakad_test" && mysql -uroot siakad_test < database/siakad-st.sql
export database.tests.hostname=127.0.0.1 database.tests.database=siakad_test database.tests.username=root database.tests.password= database.tests.DBDriver=MySQLi database.tests.DBPrefix=
vendor/bin/phpunit
```

Di GitHub, test berjalan otomatis setiap push lewat `.github/workflows/tests.yml`.
