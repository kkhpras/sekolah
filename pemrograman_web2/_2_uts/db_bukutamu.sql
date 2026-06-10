-- =====================================================
-- Database: db_bukutamu
-- Buku Tamu Digital Sekolah
-- =====================================================

CREATE DATABASE IF NOT EXISTS db_bukutamu
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_unicode_ci;

USE db_bukutamu;

DROP TABLE IF EXISTS buku_tamu;

CREATE TABLE buku_tamu (
  id        INT(11)      NOT NULL AUTO_INCREMENT,
  nama      VARCHAR(100) NOT NULL,
  instansi  VARCHAR(100) NOT NULL,
  tujuan    TEXT         NOT NULL,
  tanggal   DATE         NOT NULL,
  waktu     TIME         NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Contoh data dummy
INSERT INTO buku_tamu (nama, instansi, tujuan, tanggal, waktu) VALUES
('Budi Santoso',     'Dinas Pendidikan Kota', 'Kunjungan monitoring kegiatan sekolah',  CURDATE(), CURTIME()),
('Siti Aminah',      'Universitas Negeri XYZ', 'Penelitian skripsi bidang pendidikan',  CURDATE(), CURTIME()),
('Ahmad Fauzi',      'Orang Tua/Wali Murid',   'Konsultasi perkembangan anak kelas 6',  CURDATE(), CURTIME());
