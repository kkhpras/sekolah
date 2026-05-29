<?php
require 'db.php';
$conn = koneksi();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';

if ($id <= 0) {
    tampilkan_error_query(
        'UPDATE - ID Tidak Valid',
        'ID kontak harus berupa angka positif.',
        'ID yang diterima: ' . htmlspecialchars($id)
    );
}

$stmt = mysqli_prepare($conn, "UPDATE contacts SET name = ?, email = ?, phone = ? WHERE id = ?");
if (!$stmt) {
    tampilkan_error_query(
        'UPDATE - Prepare Statement',
        mysqli_error($conn),
        "UPDATE contacts SET name = ?, email = ?, phone = ? WHERE id = ?"
    );
}
mysqli_stmt_bind_param($stmt, 'sssi', $name, $email, $phone, $id);
$ok = mysqli_stmt_execute($stmt);
if (!$ok) {
    tampilkan_error_query(
        'UPDATE - Update Kontak',
        mysqli_stmt_error($stmt),
        "UPDATE contacts SET name = '$name', email = '$email', phone = '$phone' WHERE id = $id"
    );
}
mysqli_stmt_close($stmt);
mysqli_close($conn);
header('Location: index.php');
exit;

?>
