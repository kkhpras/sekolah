<?php
require 'db.php';
$conn = koneksi();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    die('ID tidak valid');
}

$stmt = mysqli_prepare($conn, "SELECT id, name, email, phone FROM contacts WHERE id = ?");
if (!$stmt) {
    tampilkan_error_query(
        'READ - Prepare Statement',
        mysqli_error($conn),
        "SELECT id, name, email, phone FROM contacts WHERE id = ?"
    );
}
mysqli_stmt_bind_param($stmt, 'i', $id);
$exec = mysqli_stmt_execute($stmt);
if (!$exec) {
    tampilkan_error_query(
        'READ - Ambil Data Kontak',
        mysqli_stmt_error($stmt),
        "SELECT id, name, email, phone FROM contacts WHERE id = $id"
    );
}
mysqli_stmt_bind_result($stmt, $rid, $rname, $remail, $rphone);
if (!mysqli_stmt_fetch($stmt)) {
    tampilkan_error_query(
        'READ - Data Tidak Ditemukan',
        "Kontak dengan ID $id tidak ditemukan dalam database.",
        "SELECT id, name, email, phone FROM contacts WHERE id = $id"
    );
}
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Edit Kontak</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Edit Kontak</h1>
    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($rid); ?>">
        <label>Nama<br><input type="text" name="name" value="<?php echo htmlspecialchars($rname); ?>" required></label><br>
        <label>Email<br><input type="email" name="email" value="<?php echo htmlspecialchars($remail); ?>" required></label><br>
        <label>Telepon<br><input type="text" name="phone" value="<?php echo htmlspecialchars($rphone); ?>"></label><br>
        <button type="submit">Perbarui</button>
    </form>
    <p><a href="index.php">Kembali ke daftar</a></p>
</body>
</html>
