<?php
require_once __DIR__ . '/includes/koneksi.php';

/* Ambil & sanitasi input */
$nama     = trim($_POST['nama']     ?? '');
$instansi = trim($_POST['instansi'] ?? '');
$tujuan   = trim($_POST['tujuan']   ?? '');
$tanggal  = date('Y-m-d');
$waktu    = date('H:i:s');

$errors = [];
if ($nama === '')     $errors[] = 'Nama lengkap wajib diisi.';
if ($instansi === '') $errors[] = 'Instansi wajib diisi.';
if ($tujuan === '')   $errors[] = 'Tujuan kedatangan wajib diisi.';

if (!empty($errors)) {
    http_response_code(422);
    echo '<div class="alert alert-danger"><ul class="mb-0">';
    foreach ($errors as $e) echo '<li>' . htmlspecialchars($e) . '</li>';
    echo '</ul></div>';
    exit;
}

$stmt = mysqli_prepare(
    $koneksi,
    'INSERT INTO buku_tamu (nama, instansi, tujuan, tanggal, waktu) VALUES (?, ?, ?, ?, ?)'
);
mysqli_stmt_bind_param($stmt, 'sssss', $nama, $instansi, $tujuan, $tanggal, $waktu);

if (mysqli_stmt_execute($stmt)) {
    echo '<div class="alert alert-success">Terima kasih, data tamu berhasil disimpan.</div>';
} else {
    http_response_code(500);
    echo '<div class="alert alert-danger">Gagal menyimpan data: ' . htmlspecialchars(mysqli_error($koneksi)) . '</div>';
}
mysqli_stmt_close($stmt);
