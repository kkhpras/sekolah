<?php
require 'db.php';
$conn = koneksi();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    if ($id <= 0) {
        tampilkan_error_query(
            'DELETE - ID Tidak Valid',
            'ID kontak harus berupa angka positif.',
            'ID yang diterima: ' . htmlspecialchars($id)
        );
    }
    $stmt = mysqli_prepare($conn, "DELETE FROM contacts WHERE id = ?");
    if (!$stmt) {
        tampilkan_error_query(
            'DELETE - Prepare Statement',
            mysqli_error($conn),
            "DELETE FROM contacts WHERE id = ?"
        );
    }
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $ok = mysqli_stmt_execute($stmt);
    if (!$ok) {
        tampilkan_error_query(
            'DELETE - Hapus Kontak',
            mysqli_stmt_error($stmt),
            "DELETE FROM contacts WHERE id = $id"
        );
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header('Location: index.php');
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    tampilkan_error_query(
        'DELETE - ID Tidak Valid',
        'ID kontak harus berupa angka positif.',
        'ID yang diterima: ' . htmlspecialchars($id)
    );
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Hapus Kontak</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Hapus Kontak</h1>
    <p>Yakin ingin menghapus kontak dengan ID <?php echo htmlspecialchars($id); ?>?</p>
    <form method="post" action="delete.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <button type="submit">Ya, hapus</button>
        <a href="index.php">Batal</a>
    </form>
</body>
</html>
