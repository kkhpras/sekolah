# Buku Tamu Digital Sekolah

Aplikasi web buku tamu digital sederhana berbasis **PHP + MySQL + Bootstrap 5**.

## Struktur File

```
bukutamu/
├── index.php            # Halaman form tamu
├── proses_tamu.php      # Handler submit form (INSERT ke MySQL)
├── daftar_tamu.php      # Halaman tabel daftar tamu + pencarian
├── db_bukutamu.sql      # Skrip database + contoh data
├── includes/
│   └── koneksi.php      # Konfigurasi koneksi mysqli
└── css/
    └── style.css        # Custom styling
```

## Cara Menjalankan

1. **Import database**
   - Buka phpMyAdmin (atau klien MySQL lain).
   - Import file `db_bukutamu.sql`.

2. **Atur koneksi** (jika perlu)
   - Buka `includes/koneksi.php`, sesuaikan `$host`, `$user`, `$password`.

3. **Letakkan folder** di document root server lokal:
   - XAMPP: `htdocs/bukutamu/`

4. **Akses** di browser:
   ```
   http://localhost/bukutamu/
   ```

## Fitur

- Form tamu dengan validasi (nama, instansi, tujuan wajib).
- Tanggal & waktu otomatis terisi.
- Penyimpanan aman menggunakan **prepared statement (mysqli)**.
- Tabel daftar tamu dengan `table-striped`, `table-hover`, dan badge instansi.

## Skema Tabel `buku_tamu`

| Kolom     | Tipe           | Keterangan          |
|-----------|----------------|---------------------|
| id        | INT, AI, PK    | ID otomatis        |
| nama      | VARCHAR(100)   | Nama lengkap tamu  |
| instansi  | VARCHAR(100)   | Asal instansi      |
| tujuan    | TEXT           | Tujuan kedatangan  |
| tanggal   | DATE           | Tanggal kunjungan  |
| waktu     | TIME           | Jam kunjungan      |
