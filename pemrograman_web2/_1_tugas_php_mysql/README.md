# Aplikasi Mini CRUD (mysqli procedural)

Deskripsi singkat:
Proyek ini adalah contoh aplikasi web mini yang melakukan operasi CRUD (Create, Read, Update, Delete) menggunakan ekstensi `mysqli` dengan gaya procedural.

Cara pakai singkat:
1. Import `init.sql` ke MySQL: jalankan `mysql -u root -p < init.sql` atau gunakan tool GUI.
2. Sesuaikan kredensial di `db.php` jika perlu.
3. Jalankan server php built-in dari folder proyek:

```bash
php -S localhost:8000
```

4. Buka browser ke `http://localhost:8000`.

Style mysqli yang digunakan:
- Menggunakan `mysqli_connect`, `mysqli_query`, dan prepared statements (`mysqli_prepare`, `mysqli_stmt_bind_param`, `mysqli_stmt_execute`) dalam gaya procedural.
- Menampilkan pesan error jika koneksi atau query gagal melalui `mysqli_connect_error()` dan `mysqli_error()`/`mysqli_stmt_error()`.

Struktur database:
- Database: `php_mysql_app`
- Tabel: `contacts`
  - `id` INT AUTO_INCREMENT PRIMARY KEY
  - `name` VARCHAR(100)
  - `email` VARCHAR(100)
  - `phone` VARCHAR(20)
  - `created_at` TIMESTAMP

Alur kerja aplikasi:
- `index.php`: Menampilkan daftar kontak (Read).
- `create.php` + `store.php`: Form tambah data dan handler yang melakukan INSERT menggunakan prepared statement (Create).
- `edit.php` + `update.php`: Form edit terisi, dan handler melakukan UPDATE menggunakan prepared statement (Update).
- `delete.php`: Konfirmasi penghapusan dan handler melakukan DELETE menggunakan prepared statement (Delete).

Catatan keamanan & pengujian:
- Input user diproses dengan prepared statements untuk mencegah SQL injection.
- Tampilkan pesan error jika koneksi atau query gagal untuk memudahkan debugging tugas kuliah (sesuaikan untuk produksi).
