document.getElementById('loginForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const username = document.getElementById('username').value.trim();
  const password = document.getElementById('password').value.trim();

  if (username === '' || password === '') {
    alert('Silakan isi semua kolom.');
    return;
  }

  // Simulasi autentikasi sederhana (frontend only)
  if (username === 'admin' && password === 'admin123') {
    window.location.href = '/src/Views/admin/dashboard.html';
  } else if (username === 'personil' && password === 'personil123') {
    window.location.href = '/src/Views/personil/dashboard.html';
  } else {
    alert('Username atau password salah.');
  }
});
