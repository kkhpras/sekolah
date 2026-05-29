<?php
require 'db.php';
$conn = koneksi();

$sql = "SELECT * FROM contacts ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
if (!$result) {
    tampilkan_error_query(
        'READ - Menampilkan Daftar Kontak',
        mysqli_error($conn),
        $sql
    );
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Daftar Kontak</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Daftar Kontak</h1>
    <p><a href="create.php">Tambah Kontak Baru</a></p>
    <table>
        <thead>
            <tr><th>ID</th><th>Nama</th><th>Email</th><th>Telepon</th><th>Aksi</th></tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a> |
                    <a href="delete.php?id=<?php echo $row['id']; ?>">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
