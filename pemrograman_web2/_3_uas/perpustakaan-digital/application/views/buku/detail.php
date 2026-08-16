<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0"><i class="bi bi-eye"></i> Detail Buku</h2>
        <p class="text-muted mb-0">Informasi lengkap buku</p>
    </div>
    <a href="<?php echo base_url('buku'); ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<!-- Detail Buku -->
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-book"></i> <?php echo $buku->judul; ?></h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <th width="180"><i class="bi bi-tag"></i> ISBN</th>
                        <td><code><?php echo $buku->isbn; ?></code></td>
                    </tr>
                    <tr class="border-top">
                        <th><i class="bi bi-person"></i> Penulis</th>
                        <td><?php echo $buku->penulis; ?></td>
                    </tr>
                    <tr class="border-top">
                        <th><i class="bi bi-building"></i> Penerbit</th>
                        <td><?php echo $buku->penerbit; ?></td>
                    </tr>
                    <tr class="border-top">
                        <th><i class="bi bi-calendar3"></i> Tahun Terbit</th>
                        <td><?php echo $buku->tahun; ?></td>
                    </tr>
                    <tr class="border-top">
                        <th><i class="bi bi-collection"></i> Kategori</th>
                        <td><span class="badge bg-info text-dark"><?php echo $buku->kategori; ?></span></td>
                    </tr>
                    <tr class="border-top">
                        <th><i class="bi bi-box-seam"></i> Stok</th>
                        <td>
                            <span class="badge <?php echo $buku->stok > 0 ? 'bg-success' : 'bg-danger'; ?> fs-6">
                                <?php echo $buku->stok; ?> eksemplar
                            </span>
                        </td>
                    </tr>
                    <tr class="border-top">
                        <th><i class="bi bi-clock"></i> Ditambahkan</th>
                        <td><?php echo date('d F Y, H:i:s', strtotime($buku->created_at)); ?></td>
                    </tr>
                    <tr class="border-top">
                        <th><i class="bi bi-clock-history"></i> Diperbarui</th>
                        <td><?php echo date('d F Y, H:i:s', strtotime($buku->updated_at)); ?></td>
                    </tr>
                    <?php if ($buku->deskripsi): ?>
                    <tr class="border-top">
                        <th class="align-top"><i class="bi bi-card-text"></i> Deskripsi</th>
                        <td><?php echo nl2br($buku->deskripsi); ?></td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4 mt-3 mt-md-0">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-gear"></i> Aksi</h5>
            </div>
            <div class="card-body d-grid gap-2">
                <a href="<?php echo base_url('buku/edit/' . $buku->id); ?>" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit Buku
                </a>
                <button onclick="confirmDelete('<?php echo base_url('buku/delete/' . $buku->id); ?>', '<?php echo addslashes($buku->judul); ?>')" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Hapus Buku
                </button>
                <hr>
                <a href="<?php echo base_url('buku'); ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>
