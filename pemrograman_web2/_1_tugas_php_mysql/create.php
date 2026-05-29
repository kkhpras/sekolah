<?php
// Form tambah kontak
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Tambah Kontak</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Tambah Kontak</h1>
    <form action="store.php" method="post">
        <label>Nama<br><input type="text" name="name" required></label><br>
        <label>Email<br><input type="email" name="email" required></label><br>
        <label>Telepon<br><input type="text" name="phone"></label><br>
        <button type="submit">Simpan</button>
    </form>
    <p><a href="index.php">Kembali ke daftar</a></p>
</body>
</html>
