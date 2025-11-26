<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SE Laboratory</title>

    <!-- SB Admin 2 + Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font (Nunito for SB Admin 2) -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Custom Login CSS -->
    <link rel="stylesheet" href="/assets/css/auth/login.css">
</head>


<body class="bg-gradient-primary d-flex align-items-center justify-content-center" style="min-height: 100vh;">

    <div class="container">
        <div class="row justify-content-center">

            <div class="col-xl-5 col-lg-6 col-md-8">

                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">

                        <div class="text-center mb-4">
                            <div class="logo-icon mb-2">SE</div>
                            <h4 class="fw-bold text-primary">SE Laboratory</h4>
                            <p class="text-muted">Masuk ke Akun Anda</p>
                        </div>

                        <?php
                        use App\Helpers\SessionHelper;

                        $errorMsg = SessionHelper::getFlash('error');
                        if ($errorMsg): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($errorMsg) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php
                        $successMsg = SessionHelper::getFlash('success');
                        if ($successMsg): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars($successMsg) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid_credentials'): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>Username atau password salah!
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form id="loginForm" action="/login" method="POST">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">NIM atau NIP Anda</label>
                                <input type="text" class="form-control" id="nim_nip" name="nim_nip" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kata Sandi</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">Ingat saya</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2">
                                Masuk
                            </button>

                        </form>

                        <footer class="mt-4 text-center text-muted small">
                            © 2025 Software Engineering Laboratory
                        </footer>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/login.js"></script>

</body>

</html>
