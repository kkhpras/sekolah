<?php
// db.php - koneksi mysqli procedural

// Fungsi untuk menampilkan halaman error di browser
function tampilkan_error_page($judul, $pesan_error, $detail = '') {
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="utf-8">
        <title><?php echo htmlspecialchars($judul); ?></title>
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body { 
                font-family: Arial, sans-serif; 
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }
            .error-container {
                background: white;
                border-radius: 8px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
                max-width: 600px;
                width: 100%;
                padding: 40px;
            }
            .error-icon {
                font-size: 48px;
                margin-bottom: 20px;
                text-align: center;
            }
            h1 {
                color: #d32f2f;
                margin-bottom: 15px;
                text-align: center;
                font-size: 24px;
            }
            .error-message {
                background: #ffebee;
                color: #c62828;
                padding: 15px;
                border-left: 4px solid #d32f2f;
                border-radius: 4px;
                margin-bottom: 20px;
            }
            .error-detail {
                background: #f5f5f5;
                color: #424242;
                padding: 15px;
                border-radius: 4px;
                font-family: 'Courier New', monospace;
                font-size: 13px;
                word-wrap: break-word;
                max-height: 300px;
                overflow-y: auto;
            }
            .error-detail-label {
                font-weight: bold;
                color: #666;
                margin-top: 15px;
                margin-bottom: 5px;
            }
            .suggestions {
                margin-top: 20px;
                padding-top: 20px;
                border-top: 1px solid #ddd;
            }
            .suggestions h3 {
                color: #1976d2;
                margin-bottom: 10px;
                font-size: 14px;
            }
            .suggestions ul {
                margin-left: 20px;
                color: #666;
                font-size: 13px;
                line-height: 1.8;
            }
            .back-link {
                display: inline-block;
                margin-top: 20px;
                padding: 10px 20px;
                background: #1976d2;
                color: white;
                text-decoration: none;
                border-radius: 4px;
                text-align: center;
            }
            .back-link:hover {
                background: #1565c0;
            }
        </style>
    </head>
    <body>
        <div class="error-container">
            <div class="error-icon">⚠️</div>
            <h1><?php echo htmlspecialchars($judul); ?></h1>
            <div class="error-message">
                <?php echo htmlspecialchars($pesan_error); ?>
            </div>
            <?php if ($detail): ?>
            <div class="error-detail-label">Detail Teknis:</div>
            <div class="error-detail">
                <?php echo htmlspecialchars($detail); ?>
            </div>
            <?php endif; ?>
            <div class="suggestions">
                <h3>💡 Saran:</h3>
                <ul>
                    <li>Pastikan MySQL Server sudah berjalan</li>
                    <li>Periksa kredensial database (user, password)</li>
                    <li>Verifikasi nama database sudah benar</li>
                    <li>Hubungi administrator jika masalah berlanjut</li>
                </ul>
            </div>
            <a href="index.php" class="back-link">← Kembali ke Halaman Utama</a>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// Fungsi untuk menampilkan error query
function tampilkan_error_query($operasi, $pesan_error, $query = '') {
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="utf-8">
        <title>Error Query Database</title>
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body { 
                font-family: Arial, sans-serif; 
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }
            .error-container {
                background: white;
                border-radius: 8px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
                max-width: 600px;
                width: 100%;
                padding: 40px;
            }
            h1 {
                color: #d32f2f;
                margin-bottom: 15px;
                text-align: center;
                font-size: 24px;
            }
            .error-message {
                background: #ffebee;
                color: #c62828;
                padding: 15px;
                border-left: 4px solid #d32f2f;
                border-radius: 4px;
                margin-bottom: 20px;
            }
            .error-detail {
                background: #f5f5f5;
                color: #424242;
                padding: 15px;
                border-radius: 4px;
                font-family: 'Courier New', monospace;
                font-size: 13px;
                word-wrap: break-word;
                max-height: 300px;
                overflow-y: auto;
            }
            .error-detail-label {
                font-weight: bold;
                color: #666;
                margin-top: 15px;
                margin-bottom: 5px;
            }
            .back-link {
                display: inline-block;
                margin-top: 20px;
                padding: 10px 20px;
                background: #1976d2;
                color: white;
                text-decoration: none;
                border-radius: 4px;
            }
            .back-link:hover {
                background: #1565c0;
            }
        </style>
    </head>
    <body>
        <div class="error-container">
            <h1>⚠️ Error Query Database</h1>
            <div class="error-message">
                Operasi: <strong><?php echo htmlspecialchars($operasi); ?></strong>
                <br><br>
                <?php echo htmlspecialchars($pesan_error); ?>
            </div>
            <?php if ($query): ?>
            <div class="error-detail-label">Query yang dijalankan:</div>
            <div class="error-detail">
                <?php echo htmlspecialchars($query); ?>
            </div>
            <?php endif; ?>
            <a href="javascript:history.back();" class="back-link">← Kembali</a>
        </div>
    </body>
    </html>
    <?php
    exit;
}

function koneksi() {
    $db_host = 'localhost';
    $db_user = 'phpapp';
    $db_pass = 'rahasia123';
    $db_name = 'php_mysql_app';

    try {
        // Disable exception mode untuk sementara
        $error_mode = mysqli_report(MYSQLI_REPORT_OFF);
        
        $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
        
        // Kembalikan ke mode sebelumnya
        mysqli_report($error_mode);
        
        if (!$conn) {
            tampilkan_error_page(
                'Koneksi Database Gagal',
                'Aplikasi tidak dapat terhubung ke database. Silakan cek konfigurasi database Anda.',
                'Error: ' . mysqli_connect_error() . "\n\n" .
                'Konfigurasi:\n' .
                "Host: $db_host\n" .
                "User: $db_user\n" .
                "Database: $db_name"
            );
        }
        mysqli_set_charset($conn, 'utf8mb4');
        return $conn;
    } catch (Exception $e) {
        tampilkan_error_page(
            'Koneksi Database Gagal',
            'Aplikasi tidak dapat terhubung ke database. Silakan cek konfigurasi database Anda.',
            'Error: ' . $e->getMessage() . "\n\n" .
            'Konfigurasi:\n' .
            "Host: $db_host\n" .
            "User: $db_user\n" .
            "Database: $db_name"
        );
    }
}

?>
