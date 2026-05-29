<?php
require 'db.php';
$conn = koneksi();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';

// Prepared statement untuk keamanan
$stmt = mysqli_prepare($conn, "INSERT INTO contacts (name, email, phone) VALUES (?, ?, ?)");
if (!$stmt) {
    tampilkan_error_query(
        'CREATE - Prepare Statement',
        mysqli_error($conn),
        "INSERT INTO contacts (name, email, phone) VALUES (?, ?, ?)"
    );
}
mysqli_stmt_bind_param($stmt, 'sss', $name, $email, $phone);
$ok = mysqli_stmt_execute($stmt);
if (!$ok) {
    tampilkan_error_query(
        'CREATE - Insert Kontak Baru',
        mysqli_stmt_error($stmt),
        "INSERT INTO contacts (name, email, phone) VALUES ('$name', '$email', '$phone')"
    );
}
mysqli_stmt_close($stmt);
mysqli_close($conn);
header('Location: index.php');
exit;

?>
