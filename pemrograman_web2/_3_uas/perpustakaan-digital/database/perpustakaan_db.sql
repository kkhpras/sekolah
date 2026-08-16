-- ============================================
-- DATABASE: Perpustakaan Digital
-- Nama Database: perpustakaan_db
-- ============================================
-- Buat database terlebih dahulu:
-- CREATE DATABASE IF NOT EXISTS perpustakaan_db;
-- USE perpustakaan_db;
-- ============================================

CREATE DATABASE IF NOT EXISTS perpustakaan_db;
USE perpustakaan_db;

-- ============================================
-- TABEL: users
-- Untuk penyimpanan data user/admin
-- ============================================
CREATE TABLE IF NOT EXISTS users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    level ENUM('admin', 'petugas') NOT NULL DEFAULT 'petugas',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- TABEL: buku
-- Untuk penyimpanan data buku perpustakaan
-- ============================================
CREATE TABLE IF NOT EXISTS buku (
    id INT(11) NOT NULL AUTO_INCREMENT,
    judul VARCHAR(255) NOT NULL,
    penulis VARCHAR(150) NOT NULL,
    penerbit VARCHAR(150) NOT NULL,
    tahun INT(4) NOT NULL,
    isbn VARCHAR(13) NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    stok INT(11) NOT NULL DEFAULT 0,
    deskripsi TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY isbn (isbn),
    INDEX idx_judul (judul),
    INDEX idx_penulis (penulis),
    INDEX idx_kategori (kategori),
    INDEX idx_penerbit (penerbit)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- DATA AWAL: Users
-- Password di-hash menggunakan MD5
-- admin    : admin123
-- petugas  : petugas123
-- ============================================
INSERT INTO users (username, password, nama_lengkap, level) VALUES
('admin', MD5('admin123'), 'Administrator', 'admin'),
('petugas', MD5('petugas123'), 'Petugas Perpustakaan', 'petugas');

-- ============================================
-- DATA AWAL: Sample Buku (15 data)
-- Digunakan untuk demo searching & pagination
-- ============================================
INSERT INTO buku (judul, penulis, penerbit, tahun, isbn, kategori, stok, deskripsi) VALUES
('Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', 2005, '9789791227016', 'Fiksi', 15, 'Novel tentang perjuangan anak-anak Belitong untuk mendapatkan pendidikan yang layak. Kisah inspiratif yang menggugah hati tentang semangat belajar di tengah keterbatasan.'),
('Bumi Manusia', 'Pramoedya Ananta Toer', 'Hasta Mitra', 1980, '9789799023002', 'Sastra', 10, 'Novel pertama dari Tetralogi Buru karya Pramoedya Ananta Toer. Mengisahkan perjalanan Minke di era kolonial Belanda.'),
('Filosofi Teras', 'Henry Manampiring', 'Penerbit Buku Kompas', 2018, '9786074186784', 'Non-Fiksi', 12, 'Buku tentang filsafat Stoisisme yang dikemas dengan gaya bahasa modern dan ringan untuk kehidupan sehari-hari.'),
('Sapiens: Riwayat Singkat Umat Manusia', 'Yuval Noah Harari', 'HarperCollins', 2011, '9780062316097', 'Sejarah', 8, 'Sebuah eksplorasi mendalam tentang sejarah umat manusia dari zaman purba hingga era modern.'),
('Clean Code', 'Robert C. Martin', 'Prentice Hall', 2008, '9780132350884', 'Teknologi', 7, 'Panduan praktis untuk menulis kode yang bersih, mudah dibaca, dan mudah dipelihara bagi para programmer.'),
('The Art of War', 'Sun Tzu', 'Various', -500, '9781590302255', 'Sejarah', 5, 'Karya klasik tentang strategi militer kuno Tiongkok yang masih relevan dalam bisnis dan kehidupan modern.'),
('Atomic Habits', 'James Clear', 'Avery', 2018, '9780735211292', 'Non-Fiksi', 20, 'Buku tentang cara membangun kebiasaan baik dan menghilangkan kebiasaan buruk secara bertahap dan efektif.'),
('Dilan 1990', 'Pidi Baiq', 'Pastel Books', 2014, '9786027870589', 'Fiksi', 25, 'Novel romantis yang mengisahkan cinta sepasang remaja di Bandung tahun 1990. Menjadi fenomena budaya pop Indonesia.'),
('Sejarah Dunia yang Disembunyikan', 'Jonathan Black', 'Quercus', 2007, '9781847241420', 'Sejarah', 6, 'Buku yang mengungkap sisi tersembunyi dari sejarah peradaban dunia dari perspektif yang berbeda.'),
('Introduction to Algorithms', 'Thomas H. Cormen', 'MIT Press', 2009, '9780262033848', 'Teknologi', 4, 'Buku referensi standar untuk studi algoritma dan struktur data. Digunakan di banyak universitas terkemuka dunia.'),
('Laut Bercerita', 'Leila S. Chudori', 'Kepustakaan Populer Gramedia', 2017, '9786024810354', 'Sastra', 9, 'Novel tentang aktivis mahasiswa yang hilang selama era Orde Baru. Kisah penuh emosi tentang perjuangan dan pengorbanan.'),
('Psikologi Kriminal', 'Dr. Handoko S.', 'Grasindo', 2019, '9786027558912', 'Pendidikan', 3, 'Buku yang membahas psikologi di balik perilaku kriminal, profil pelaku kejahatan, dan pendekatan forensik psikologis.'),
('Naruto Vol. 1', 'Masashi Kishimoto', 'Elex Media Komputindo', 1999, '9789792227590', 'Komik', 30, 'Komik pertama dari seri Naruto yang menceritakan petualangan ninja muda Uzumaki Naruto yang bermimpi menjadi Hokage.'),
('Al-Quran dan Terjemahnya', 'Kementerian Agama RI', 'Kementerian Agama', 2019, '9789790115980', 'Agama', 50, 'Al-Quran terjemahan bahasa Indonesia resmi dari Kementerian Agama Republik Indonesia.'),
('A Brief History of Time', 'Stephen Hawking', 'Bantam Books', 1988, '9780553380163', 'Sains', 6, 'Buku sains populer yang menjelaskan konsep fisika seperti lubang hitam, big bang, dan waktu kepada pembaca umum.');

-- ============================================
-- SELESAI - Database siap digunakan
-- ============================================
