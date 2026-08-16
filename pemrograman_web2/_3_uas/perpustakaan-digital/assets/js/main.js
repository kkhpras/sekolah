/**
 * Perpustakaan Digital - Main JavaScript
 * Handles delete confirmation and form interactions
 */

// Konfirmasi hapus buku dengan SweetAlert-style custom modal
function confirmDelete(url, judul) {
    if (confirm('Apakah Anda yakin ingin menghapus buku:\n\n"' + judul + '"\n\nAksi ini tidak dapat dibatalkan!')) {
        window.location.href = url;
    }
}

// Reset form fields
function resetForm(formId) {
    document.getElementById(formId).reset();
}
