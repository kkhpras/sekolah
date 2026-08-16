<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0"><i class="bi bi-journal-bookmark"></i> Data Buku</h2>
        <p class="text-muted mb-0">Kelola koleksi buku perpustakaan digital</p>
    </div>
    <a href="<?php echo base_url('buku/create'); ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Buku
    </a>
</div>

<!-- Search Box -->
<div class="card mb-4">
    <div class="card-body">
        <?php echo form_open('buku', array('method' => 'get', 'class' => 'row g-2')); ?>
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" name="q" placeholder="Cari berdasarkan judul, penulis, penerbit, ISBN, atau kategori..." value="<?php echo isset($keyword) ? $keyword : ''; ?>">
                    <?php if (isset($keyword) && $keyword != ''): ?>
                    <a href="<?php echo base_url('buku'); ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg"></i> Reset
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Cari Buku
                </button>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>

<!-- Info Searching -->
<?php if (isset($keyword) && $keyword != ''): ?>
<div class="alert alert-info d-flex justify-content-between align-items-center">
    <span><i class="bi bi-info-circle"></i> Hasil pencarian untuk: <strong>"<?php echo $keyword; ?>"</strong> - Ditemukan <strong><?php echo $total; ?></strong> buku</span>
    <a href="<?php echo base_url('buku'); ?>" class="btn btn-sm btn-outline-info">Lihat Semua</a>
</div>
<?php endif; ?>

<!-- Tabel Buku -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th width="50">#</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Tahun</th>
                        <th>ISBN</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($buku)): ?>
                        <?php foreach ($buku as $b): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td>
                                <a href="<?php echo base_url('buku/detail/' . $b->id); ?>" class="text-decoration-none fw-semibold">
                                    <?php echo character_limiter($b->judul, 40); ?>
                                </a>
                            </td>
                            <td><?php echo $b->penulis; ?></td>
                            <td><?php echo $b->penerbit; ?></td>
                            <td class="text-center"><?php echo $b->tahun; ?></td>
                            <td><code><?php echo $b->isbn; ?></code></td>
                            <td><span class="badge bg-info text-dark"><?php echo $b->kategori; ?></span></td>
                            <td class="text-center">
                                <span class="badge <?php echo $b->stok > 0 ? 'bg-success' : 'bg-danger'; ?>">
                                    <?php echo $b->stok; ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?php echo base_url('buku/detail/' . $b->id); ?>" class="btn btn-sm btn-info" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="<?php echo base_url('buku/edit/' . $b->id); ?>" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button onclick="confirmDelete('<?php echo base_url('buku/delete/' . $b->id); ?>', '<?php echo addslashes($b->judul); ?>')" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1"></i>
                                <h5 class="mt-2">Tidak ada data buku</h5>
                                <?php if (isset($keyword) && $keyword != ''): ?>
                                <p class="mb-0">Tidak ditemukan buku dengan kata kunci "<strong><?php echo $keyword; ?></strong>"</p>
                                <a href="<?php echo base_url('buku/create'); ?>" class="btn btn-primary mt-2"><i class="bi bi-plus-lg"></i> Tambah Buku Baru</a>
                                <?php else: ?>
                                <a href="<?php echo base_url('buku/create'); ?>" class="btn btn-primary mt-2"><i class="bi bi-plus-lg"></i> Tambah Buku Pertama</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination & Info -->
    <?php if (!empty($buku)): ?>
    <div class="card-footer bg-white d-flex justify-content-between align-items-center">
        <small class="text-muted">
            Menampilkan <strong><?php echo $no - count($buku); ?> - <?php echo $no - 1; ?></strong> dari <strong><?php echo $total; ?></strong> buku
        </small>
        <div>
            <?php echo $pagination; ?>
        </div>
    </div>
    <?php endif; ?>
</div>
