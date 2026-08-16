<!-- Dashboard -->
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold"><i class="bi bi-speedometer2"></i> Dashboard</h2>
        <p class="text-muted">Selamat datang kembali, <strong><?php echo $username; ?></strong>!</p>
    </div>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card stat-card border-start border-4 border-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mb-1">Total Buku</h6>
                        <h3 class="fw-bold mb-0"><?php echo number_format($total_buku); ?></h3>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-circle p-3">
                        <i class="bi bi-book fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card border-start border-4 border-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mb-1">Total Kategori</h6>
                        <h3 class="fw-bold mb-0"><?php echo number_format($total_kategori); ?></h3>
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10 text-success rounded-circle p-3">
                        <i class="bi bi-collection fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card border-start border-4 border-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mb-1">Total Stok</h6>
                        <h3 class="fw-bold mb-0"><?php echo number_format($total_stok); ?></h3>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning rounded-circle p-3">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Buku Terbaru -->
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="bi bi-clock-history"></i> Buku Terbaru Ditambahkan</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Tanggal Ditambahkan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($buku_terbaru)): ?>
                        <?php $no = 1; foreach ($buku_terbaru as $b): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><strong><?php echo $b->judul; ?></strong></td>
                            <td><?php echo $b->penulis; ?></td>
                            <td><span class="badge bg-info"><?php echo $b->kategori; ?></span></td>
                            <td><span class="badge bg-success"><?php echo $b->stok; ?></span></td>
                            <td><?php echo date('d M Y, H:i', strtotime($b->created_at)); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-2"></i><br>Belum ada data buku
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
