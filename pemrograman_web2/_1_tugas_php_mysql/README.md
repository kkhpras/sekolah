# Aplikasi Mini CRUD (mysqli procedural)

Deskripsi singkat
Proyek ini adalah contoh aplikasi web sederhana yang menunjukkan operasi CRUD (Create, Read, Update, Delete) menggunakan ekstensi `mysqli` dengan gaya procedural.

Fitur utama
- CRUD untuk entitas `contacts` (id, name, email, phone, created_at).
- Menggunakan prepared statements untuk mencegah SQL injection.
- Halaman error kustom di `db.php` untuk membantu debugging.

Persyaratan
- PHP 7.0+ dengan ekstensi `mysqli` terpasang.
- MySQL / MariaDB.

Instalasi & setup cepat
1. Import struktur dan data awal ke MySQL:

```bash
mysql -u root -p < init.sql
```

2. Sesuaikan kredensial database di `db.php` jika diperlukan (host, user, password, database).

3. Jalankan server PHP built-in dari folder proyek:

```bash
php -S localhost:8000
```

4. Buka browser ke http://localhost:8000

Catatan konfigurasi
- File koneksi: `db.php` — nilai default di file ini untuk demo adalah:
  - host: `localhost`
  - user: `phpapp`
  - password: `rahasia123`
  - database: `php_mysql_app`

Struktur berkas (ringkas)
- `index.php` — daftar kontak (Read)
- `create.php` — form tambah data (Create)
- `store.php` — handler INSERT (Create)
- `edit.php` — form edit (Update)
- `update.php` — handler UPDATE (Update)
- `delete.php` — konfirmasi + handler DELETE (Delete)
- `db.php` — koneksi database dan fungsi error handling
- `init.sql` — skrip pembuatan database + data contoh
- `styles.css` — stylesheet sederhana

Keamanan & catatan pengembangan
- Semua operasi database menggunakan prepared statements untuk mengurangi risiko SQL injection.
- `db.php` menampilkan halaman error yang berguna untuk debugging tugas/pembelajaran.