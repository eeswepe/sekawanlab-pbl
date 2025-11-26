document.getElementById('loginForm').addEventListener('submit', function(e) {

  const username = document.getElementById('nim_nip').value.trim();
  const password = document.getElementById('password').value.trim();

  if (username === '' || password === '') {
    e.preventDefault();
    alert('Silakan isi semua kolom.');
    return;
  }
});
