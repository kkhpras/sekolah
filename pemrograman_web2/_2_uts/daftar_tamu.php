<?php
require_once __DIR__ . '/includes/koneksi.php';

$keyword = trim($_GET['q'] ?? '');
$sql     = 'SELECT id, nama, instansi, tujuan, tanggal, waktu FROM buku_tamu';
$params  = [];
$types   = '';

if ($keyword !== '') {
    $sql   .= ' WHERE nama LIKE ? OR instansi LIKE ?';
    $like   = '%' . $keyword . '%';
    $params = [$like, $like];
    $types  = 'ss';
}

$sql .= ' ORDER BY tanggal DESC, waktu DESC';

$stmt = mysqli_prepare($koneksi, $sql);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$tamu   = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($stmt);

$total = count($tamu);
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Daftar Tamu - Buku Tamu Digital Sekolah</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold" href="index.php">
        <i class="bi bi-journal-bookmark-fill me-2"></i>Buku Tamu Digital
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="nav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php"><i class="bi bi-pencil-square me-1"></i>Isi Buku Tamu</a></li>
          <li class="nav-item"><a class="nav-link active" href="daftar_tamu.php"><i class="bi bi-list-ul me-1"></i>Daftar Tamu</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container py-5">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
      <div>
        <h2 class="fw-bold mb-1">Daftar Tamu</h2>
        <p class="text-muted mb-0">Total <?= $total ?> tamu telah tercatat.</p>
      </div>
      <a href="index.php" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Tambah Tamu
      </a>
    </div>

    <form method="get" class="row g-2 mb-4">
      <div class="col-md-8 col-lg-6">
        <div class="input-group">
          <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
          <input type="text" name="q" value="<?= htmlspecialchars($keyword) ?>"
                 class="form-control" placeholder="Cari berdasarkan nama atau instansi...">
          <button class="btn btn-primary" type="submit">Cari</button>
          <?php if ($keyword !== ''): ?>
            <a class="btn btn-outline-secondary" href="daftar_tamu.php">Reset</a>
          <?php endif; ?>
        </div>
      </div>
    </form>

    <div class="card shadow-sm border-0">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-striped table-hover align-middle mb-0">
            <thead class="table-primary">
              <tr>
                <th style="width:60px;">#</th>
                <th>Nama Lengkap</th>
                <th>Instansi</th>
                <th>Tujuan Kedatangan</th>
                <th style="width:120px;">Tanggal</th>
                <th style="width:100px;">Waktu</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($total === 0): ?>
                <tr>
                  <td colspan="6" class="text-center text-muted py-4">
                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                    Belum ada data tamu<?= $keyword !== '' ? ' yang cocok dengan pencarian.' : '.' ?>
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($tamu as $i => $row): ?>
                  <tr>
                    <td class="text-muted"><?= $i + 1 ?></td>
                    <td class="fw-semibold"><?= htmlspecialchars($row['nama']) ?></td>
                    <td><span class="badge text-bg-info"><?= htmlspecialchars($row['instansi']) ?></span></td>
                    <td><?= htmlspecialchars($row['tujuan']) ?></td>
                    <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                    <td><?= htmlspecialchars(substr($row['waktu'], 0, 5)) ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>

  <footer class="text-center text-muted py-4 border-top mt-5">
    <small>&copy; <?= date('Y') ?> Buku Tamu Digital Sekolah &middot; Dibuat dengan Bootstrap &amp; PHP</small>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
