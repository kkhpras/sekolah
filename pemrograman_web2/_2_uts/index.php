<?php
require_once __DIR__ . '/includes/koneksi.php';

$tanggal_hari_ini = date('Y-m-d');
$waktu_hari_ini   = date('H:i:s');
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Form Buku Tamu - Buku Tamu Digital Sekolah</title>
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
          <li class="nav-item"><a class="nav-link active" href="index.php"><i class="bi bi-pencil-square me-1"></i>Isi Buku Tamu</a></li>
          <li class="nav-item"><a class="nav-link" href="daftar_tamu.php"><i class="bi bi-list-ul me-1"></i>Daftar Tamu</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="text-center mb-4">
          <h1 class="fw-bold">Selamat Datang di Sekolah</h1>
          <p class="text-muted">Silakan isi buku tamu berikut untuk mencatat kunjungan Anda.</p>
        </div>

        <div class="card shadow border-0">
          <div class="card-header bg-white border-0 pt-4">
            <h5 class="card-title mb-0 fw-bold">
              <i class="bi bi-person-vcard text-primary me-2"></i>Formulir Tamu
            </h5>
          </div>
          <div class="card-body p-4">
            <div id="form-alert"></div>

            <form id="form-tamu" method="post" action="proses_tamu.php" novalidate>
              <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-person"></i></span>
                  <input type="text" id="nama" name="nama" class="form-control"
                         placeholder="Contoh: Budi Santoso" required maxlength="100">
                </div>
              </div>

              <div class="mb-3">
                <label for="instansi" class="form-label">Instansi <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-building"></i></span>
                  <input type="text" id="instansi" name="instansi" class="form-control"
                         placeholder="Contoh: Dinas Pendidikan / Orang Tua Murid" required maxlength="100">
                </div>
              </div>

              <div class="mb-3">
                <label for="tujuan" class="form-label">Tujuan Kedatangan <span class="text-danger">*</span></label>
                <textarea id="tujuan" name="tujuan" class="form-control" rows="4"
                          placeholder="Jelaskan tujuan kunjungan Anda..." required></textarea>
              </div>

              <div class="row g-3 mb-4">
                <div class="col-md-6">
                  <label class="form-label">Tanggal Kedatangan</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                    <input type="text" class="form-control bg-light" value="<?= date('d-m-Y') ?>" readonly>
                  </div>
                  <small class="text-muted">Otomatis terisi tanggal hari ini.</small>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Waktu Kedatangan</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-clock"></i></span>
                    <input type="text" id="waktu-tampil" class="form-control bg-light" readonly>
                  </div>
                  <small class="text-muted">Otomatis terisi waktu saat ini.</small>
                </div>
              </div>

              <div class="d-flex justify-content-between align-items-center">
                <a href="daftar_tamu.php" class="btn btn-outline-secondary">
                  <i class="bi bi-list-ul me-1"></i>Lihat Daftar Tamu
                </a>
                <button type="submit" class="btn btn-primary px-4">
                  <i class="bi bi-send me-1"></i>Kirim
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>

  <footer class="text-center text-muted py-4 border-top mt-5">
    <small>&copy; <?= date('Y') ?> Buku Tamu Digital Sekolah &middot; Dibuat dengan Bootstrap &amp; PHP</small>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Jam real-time
    const el = document.getElementById('waktu-tampil');
    function tick() {
      const d = new Date();
      const hh = String(d.getHours()).padStart(2, '0');
      const mm = String(d.getMinutes()).padStart(2, '0');
      const ss = String(d.getSeconds()).padStart(2, '0');
      el.value = `${hh}:${mm}:${ss}`;
    }
    tick(); setInterval(tick, 1000);

    // Submit via fetch agar alert tampil di tempat
    const form = document.getElementById('form-tamu');
    const alertBox = document.getElementById('form-alert');
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      alertBox.innerHTML = '<div class="text-muted small">Menyimpan...</div>';
      const fd = new FormData(form);
      try {
        const res = await fetch(form.action, { method: 'POST', body: fd });
        const html = await res.text();
        alertBox.innerHTML = html;
        if (res.ok && html.includes('alert-success')) {
          form.reset();
          window.scrollTo({ top: 0, behavior: 'smooth' });
        }
      } catch (err) {
        alertBox.innerHTML = '<div class="alert alert-danger">Terjadi kesalahan jaringan.</div>';
      }
    });
  </script>
</body>
</html>
