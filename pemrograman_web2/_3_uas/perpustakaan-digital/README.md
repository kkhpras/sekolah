# Perpustakaan Buku Digital
## Aplikasi Web menggunakan CodeIgniter 3 + MySQL

---

## Deskripsi Aplikasi
Aplikasi Perpustakaan Buku Digital adalah sistem informasi berbasis web untuk mengelola koleksi buku perpustakaan secara digital. Aplikasi ini dibangun menggunakan framework PHP CodeIgniter 3 dan database MySQL/MariaDB.

### Fitur Utama:
- **CRUD (Create, Read, Update, Delete)** - Pengelolaan data buku lengkap
- **Session Management** - Login/Logout, autentikasi, dan otorisasi pengguna
- **Searching** - Pencarian multi-field (judul, penulis, penerbit, ISBN, kategori)
- **Pagination** - Pembagian data per halaman (5 item per halaman)

---

## Struktur Folder

```
perpustakaan-digital/
├── application/
│   ├── controllers/
│   │   ├── Auth.php          # Controller untuk login/logout
│   │   ├── Buku.php          # Controller CRUD buku
│   │   └── Dashboard.php     # Controller dashboard
│   ├── models/
│   │   ├── Buku_model.php     # Model operasi database buku
│   │   └── User_model.php     # Model operasi database user
│   ├── views/
│   │   ├── layout/
│   │   │   ├── header.php     # Navbar dan header
│   │   │   └── footer.php     # Footer dan script
│   │   ├── auth/
│   │   │   └── login.php      # Halaman login
│   │   ├── buku/
│   │   │   ├── index.php      # Daftar buku + search + pagination
│   │   │   ├── create.php     # Form tambah buku
│   │   │   ├── edit.php       # Form edit buku
│   │   │   └── detail.php     # Detail buku
│   │   ├── dashboard/
│   │   │   └── index.php      # Halaman dashboard
│   │   └── errors/            # Template error CodeIgniter
│   │       └── html/
│   │           ├── error_php.php
│   │           ├── error_404.php
│   │           ├── error_db.php
│   │           ├── error_general.php
│   │           └── error_exception.php
│   └── config/
│       ├── autoload.php       # Library, helper, model autoload
│       ├── config.php         # Konfigurasi utama (base_url, session)
│       ├── database.php       # Konfigurasi database MySQL
│       └── routes.php         # Routing URL
├── assets/
│   ├── css/
│   │   └── style.css          # Custom stylesheet
│   └── js/
│       └── main.js            # JavaScript (delete confirmation)
├── database/
│   └── perpustakaan_db.sql    # File SQL database (struktur + data awal)
├── laporan/
│   └── Laporan_Perpustakaan_Digital.pdf  # Laporan proyek
├── index.php                  # Entry point CodeIgniter
├── router.php                 # Router untuk PHP built-in server
├── .htaccess                  # URL rewrite (untuk Apache)
└── README.md                  # File ini
```

---

## Cara Menjalankan Aplikasi

### Prasyarat:
1. **PHP 8.5** (atau versi 8.x lainnya) dengan ekstensi `mysqli`
2. **MariaDB/MySQL** (MariaDB 11.8+ direkomendasikan)
3. **CodeIgniter 3.1.13** (folder `system/` yang diperlukan)

> **Catatan Kompatibilitas PHP 8.5:**
> CodeIgniter 3 belum mendukung PHP 8.5 secara resmi. Beberapa patch telah diterapkan untuk kompatibilitas:
> - File `system/core/Exceptions.php` — menghapus referensi `E_STRICT` (dihapus di PHP 8.4+)
> - File `index.php` — mengatur `error_reporting(E_ALL & ~E_DEPRECATED)` untuk menekan deprecation warning
> - File `application/config/config.php` — `enable_query_strings` diatur ke `FALSE`
> - Template error CodeIgniter ditambahkan ke `application/views/errors/html/`

### Langkah Instalasi:

#### Langkah 1: Download CodeIgniter 3
- Download dari https://codeigniter.com/download (versi 3.1.13)
- Ekstrak, lalu salin folder `system/` ke dalam folder `perpustakaan-digital/`

#### Langkah 2: Letakkan Project
- Salin folder `perpustakaan-digital/` ke lokasi kerja yang diinginkan, contoh:
  ```
  /home/user/perpustakaan-digital/
  ```

#### Langkah 3: Buat Database
- Buat database dan user di MariaDB/MySQL:
  ```sql
  CREATE DATABASE perpustakaan_db;
  CREATE USER 'perpustakaan'@'localhost' IDENTIFIED BY 'perpustakaan123';
  GRANT ALL PRIVILEGES ON perpustakaan_db.* TO 'perpustakaan'@'localhost';
  FLUSH PRIVILEGES;
  ```
- Import file SQL:
  ```bash
  mysql -u perpustakaan -pperpustakaan123 perpustakaan_db < database/perpustakaan_db.sql
  ```

#### Langkah 4: Konfigurasi Database
- Buka file `application/config/database.php`
- Pastikan pengaturan berikut sesuai:
  ```php
  $db['default'] = array(
      'hostname' => 'localhost',
      'username' => 'perpustakaan',
      'password' => 'perpustakaan123',
      'database' => 'perpustakaan_db',
      'dbdriver' => 'mysqli',
  );
  ```

#### Langkah 5: Jalankan Server
- Jalankan menggunakan PHP built-in development server:
  ```bash
  php -S localhost:8080 router.php
  ```
  > **Penting:** Gunakan `router.php` agar routing CodeIgniter berfungsi dengan benar.

- Atau gunakan Apache/XAMPP dengan konfigurasi `.htaccess` yang sesuai.

#### Langkah 6: Akses Aplikasi
- Buka browser
- Akses: **http://localhost:8080/**
- Login dengan akun berikut:

| Level   | Username | Password     |
|---------|----------|-------------|
| Admin   | admin    | admin123    |
| Petugas | petugas  | petugas123  |

---

## Konfigurasi

| Parameter          | Nilai                                      |
|--------------------|--------------------------------------------|
| Base URL           | http://localhost:8080/                     |
| Database           | perpustakaan_db                            |
| DB Username        | perpustakaan                               |
| DB Password        | perpustakaan123                            |
| DB Driver          | mysqli                                     |
| PHP Version        | 8.5                                        |
| CodeIgniter        | 3.1.13                                     |
| Items per halaman  | 5                                          |
| Session Expiration | 7200 detik (2 jam)                         |

---

## Akun Default

Terdapat 2 akun pengguna yang sudah tersedia:

1. **Administrator** (admin)
   - Username: `admin`
   - Password: `admin123`
   - Nama: Administrator

2. **Petugas Perpustakaan** (petugas)
   - Username: `petugas`
   - Password: `petugas123`
   - Nama: Petugas Perpustakaan

---

## Teknologi yang Digunakan

| Teknologi       | Versi  | Fungsi                            |
|----------------|--------|-----------------------------------|
| PHP            | 8.5    | Bahasa pemrograman server-side    |
| CodeIgniter    | 3.1.13 | Framework PHP (MVC)               |
| MariaDB        | 11.8   | Database relasional               |
| Bootstrap      | 5.3    | CSS framework responsif            |
| Bootstrap Icons| 1.10   | Library ikon                      |

### Catatan Kompatibilitas PHP 8.5
CodeIgniter 3 belum mendukung PHP 8.5 secara resmi. Patch berikut telah diterapkan:

1. **`system/core/Exceptions.php`** — Menghapus baris `E_STRICT => 'Runtime Notice'` dari array `$levels` karena `E_STRICT` sudah dihapus di PHP 8.4+
2. **`index.php`** — Mengubah `error_reporting(-1)` menjadi `error_reporting(E_ALL & ~E_DEPRECATED)` untuk menekan deprecation warning dari CI3
3. **`application/config/config.php`** — Mengubah `enable_query_strings` dari `TRUE` menjadi `FALSE` agar routing berfungsi dengan benar
4. **Template error** — Menambahkan file error template (`error_php.php`, `error_404.php`, dll.) ke `application/views/errors/html/`
