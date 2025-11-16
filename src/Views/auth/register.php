<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SE Laboratory</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Poppins:wght@400;500&display=swap"
        rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/auth/login.css">

</head>

<body>
    <div class="login-container">
        <div class="logo">
            <div class="logo-icon">SE</div>
            <span class="logo-text">SE Laboratory</span>
        </div>

        <h5 class="mb-4 fw-semibold">Daftar Akun Baru</h5>

        <?php 
            use App\Helpers\SessionHelper;
            $error = SessionHelper::getFlash("error");
            if ($error): 
        ?>
            <div class="alert alert-danger" role="alert">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form id="registerForm" action="/register" method="POST">
            <div class="mb-3 text-start">
                <label for="secret_key" class="form-label">Secret Key</label>
                <input type="text" class="form-control" id="secret_key" name="secret_key" placeholder="Masukkan secret key dari admin" required>
                <small class="text-muted">Secret key diberikan setelah aplikasi Anda diterima</small>
            </div>

            <div class="mb-3 text-start">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>

            <div class="mb-3 text-start">
                <label for="password" class="form-label">Kata Sandi</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="mb-4 text-start">
                <label for="confirm_password" class="form-label">Konfirmasi Kata Sandi</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>

            <button type="submit" class="btn btn-login">Daftar</button>
        </form>

        <div class="mt-3">
            Sudah punya akun? <a href="/login" class="text-decoration-none">Masuk di sini</a>
        </div>

        <footer>&copy; 2025 Software Engineering Laboratory. All rights reserved.</footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Assuming login.js is for login-specific logic, we might need a register.js or just rely on form submission -->
    <!-- <script src="/assets/js/auth/login.js"></script> -->
</body>

</html>
