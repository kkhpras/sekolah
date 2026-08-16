<!-- Login Page - Tanpa layout header/footer -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perpustakaan Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .login-header {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
            padding: 30px;
            text-align: center;
            color: white;
        }
        .login-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
        }
        .login-header .icon {
            font-size: 3rem;
            margin-bottom: 10px;
        }
        .login-body {
            padding: 35px;
        }
        .form-floating {
            margin-bottom: 15px;
        }
        .btn-login {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
            border: none;
            padding: 12px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 8px;
            transition: transform 0.2s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(90, 103, 216, 0.4);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card login-card">
                    <div class="login-header">
                        <div class="icon"><i class="bi bi-book-half"></i></div>
                        <h1>Perpustakaan Digital</h1>
                        <p class="mb-0 opacity-75">Silakan login untuk masuk</p>
                    </div>
                    <div class="card-body login-body">

                        <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill"></i> <?php echo $this->session->flashdata('error'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php endif; ?>

                        <?php echo form_open('auth/proses_login'); ?>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required autofocus>
                                <label for="username"><i class="bi bi-person"></i> Username</label>
                            </div>
                            <div class="form-floating">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                <label for="password"><i class="bi bi-lock"></i> Password</label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-login w-100">
                                <i class="bi bi-box-arrow-in-right"></i> Masuk
                            </button>
                        <?php echo form_close(); ?>

                        <div class="mt-4 text-center">
                            <small class="text-muted">
                                <strong>Demo Login:</strong><br>
                                Admin: <code>admin</code> / <code>admin123</code><br>
                                User: <code>petugas</code> / <code>petugas123</code>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
