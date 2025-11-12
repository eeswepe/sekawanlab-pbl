<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SE Laboratory</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Poppins:wght@400;500&display=swap"
        rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../public/css/login.css">

</head>

<body>
    <div class="login-container">
        <div class="logo">
            <div class="logo-icon">SE</div>
            <span class="logo-text">SE Laboratory</span>
        </div>

        <h5 class="mb-4 fw-semibold">Masuk ke Akun Anda</h5>

        <form id="loginForm">
            <div class="mb-3 text-start">
                <label for="username" class="form-label">Email atau Username</label>
                <input type="text" class="form-control" id="username" required>
            </div>

            <div class="mb-2 text-start">
                <label for="password" class="form-label">Kata Sandi</label>
                <input type="password" class="form-control" id="password" required>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Ingat saya</label>
                </div>
                <a href="#" class="forgot-password">Lupa kata sandi?</a>
            </div>

            <button type="submit" class="btn btn-login">Masuk</button>
        </form>

        <footer>&copy; 2025 Software Engineering Laboratory. All rights reserved.</footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../public/js/login.js"></script>
</body>

</html>