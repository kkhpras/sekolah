<?php
/**
 * Konfigurasi koneksi database MySQL
 * Buku Tamu Digital Sekolah
 */

$host     = 'localhost';
$user     = 'bukutamu';
$password = 'password123';
$database = 'db_bukutamu';

$koneksi = mysqli_connect($host, $user, $password, $database);

if (!$koneksi) {
    die('Koneksi database gagal: ' . mysqli_connect_error());
}

mysqli_set_charset($koneksi, 'utf8mb4');
