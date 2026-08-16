<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0"><i class="bi bi-plus-circle"></i> Tambah Buku Baru</h2>
        <p class="text-muted mb-0">Isi form di bawah untuk menambahkan buku baru ke perpustakaan</p>
    </div>
    <a href="<?php echo base_url('buku'); ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<!-- Form Tambah Buku -->
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="bi bi-journal-plus"></i> Form Data Buku</h5>
    </div>
    <div class="card-body">
        <?php echo form_open('buku/create', array('id' => 'form-buku')); ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="judul" class="form-label fw-semibold">
                            Judul Buku <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control <?php echo form_error('judul') ? 'is-invalid' : ''; ?>" id="judul" name="judul" value="<?php echo set_value('judul'); ?>" placeholder="Masukkan judul buku">
                        <div class="invalid-feedback"><?php echo form_error('judul'); ?></div>
                    </div>

                    <div class="mb-3">
                        <label for="penulis" class="form-label fw-semibold">
                            Penulis <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control <?php echo form_error('penulis') ? 'is-invalid' : ''; ?>" id="penulis" name="penulis" value="<?php echo set_value('penulis'); ?>" placeholder="Masukkan nama penulis">
                        <div class="invalid-feedback"><?php echo form_error('penulis'); ?></div>
                    </div>

                    <div class="mb-3">
                        <label for="penerbit" class="form-label fw-semibold">
                            Penerbit <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control <?php echo form_error('penerbit') ? 'is-invalid' : ''; ?>" id="penerbit" name="penerbit" value="<?php echo set_value('penerbit'); ?>" placeholder="Masukkan nama penerbit">
                        <div class="invalid-feedback"><?php echo form_error('penerbit'); ?></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tahun" class="form-label fw-semibold">
                                    Tahun Terbit <span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control <?php echo form_error('tahun') ? 'is-invalid' : ''; ?>" id="tahun" name="tahun" value="<?php echo set_value('tahun'); ?>" placeholder="2024" min="1900" max="2099">
                                <div class="invalid-feedback"><?php echo form_error('tahun'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="stok" class="form-label fw-semibold">
                                    Stok <span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control <?php echo form_error('stok') ? 'is-invalid' : ''; ?>" id="stok" name="stok" value="<?php echo set_value('stok'); ?>" placeholder="0" min="0">
                                <div class="invalid-feedback"><?php echo form_error('stok'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="isbn" class="form-label fw-semibold">
                            ISBN <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control <?php echo form_error('isbn') ? 'is-invalid' : ''; ?>" id="isbn" name="isbn" value="<?php echo set_value('isbn'); ?>" placeholder="978-xxx-xxx-xxx-x">
                        <div class="invalid-feedback"><?php echo form_error('isbn'); ?></div>
                        <small class="text-muted">ISBN 10 atau 13 digit</small>
                    </div>

                    <div class="mb-3">
                        <label for="kategori" class="form-label fw-semibold">
                            Kategori <span class="text-danger">*</span>
                        </label>
                        <select class="form-select <?php echo form_error('kategori') ? 'is-invalid' : ''; ?>" id="kategori" name="kategori">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Fiksi" <?php echo set_value('kategori') == 'Fiksi' ? 'selected' : ''; ?>>Fiksi</option>
                            <option value="Non-Fiksi" <?php echo set_value('kategori') == 'Non-Fiksi' ? 'selected' : ''; ?>>Non-Fiksi</option>
                            <option value="Sains" <?php echo set_value('kategori') == 'Sains' ? 'selected' : ''; ?>>Sains</option>
                            <option value="Teknologi" <?php echo set_value('kategori') == 'Teknologi' ? 'selected' : ''; ?>>Teknologi</option>
                            <option value="Sejarah" <?php echo set_value('kategori') == 'Sejarah' ? 'selected' : ''; ?>>Sejarah</option>
                            <option value="Agama" <?php echo set_value('kategori') == 'Agama' ? 'selected' : ''; ?>>Agama</option>
                            <option value="Pendidikan" <?php echo set_value('kategori') == 'Pendidikan' ? 'selected' : ''; ?>>Pendidikan</option>
                            <option value="Sastra" <?php echo set_value('kategori') == 'Sastra' ? 'selected' : ''; ?>>Sastra</option>
                            <option value="Komik" <?php echo set_value('kategori') == 'Komik' ? 'selected' : ''; ?>>Komik</option>
                            <option value="Lainnya" <?php echo set_value('kategori') == 'Lainnya' ? 'selected' : ''; ?>>Lainnya</option>
                        </select>
                        <div class="invalid-feedback"><?php echo form_error('kategori'); ?></div>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" placeholder="Tuliskan deskripsi singkat buku (opsional)"><?php echo set_value('deskripsi'); ?></textarea>
                        <small class="text-muted">Deskripsi singkat tentang isi buku</small>
                    </div>
                </div>
            </div>

            <hr>

            <div class="d-flex justify-content-end gap-2">
                <a href="<?php echo base_url('buku'); ?>" class="btn btn-secondary">
                    <i class="bi bi-x-lg"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan Buku
                </button>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>
