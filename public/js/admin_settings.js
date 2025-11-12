document.addEventListener('DOMContentLoaded', () => {
  console.log("Admin Settings Loaded");

  // Simulasi toggle maintenance mode
  const toggle = document.getElementById('maintenanceMode');
  if (toggle) {
    toggle.addEventListener('change', () => {
      alert(toggle.checked
        ? 'Maintenance mode diaktifkan'
        : 'Maintenance mode dinonaktifkan');
    });
  }

  // Simulasi tombol simpan
  const saveButtons = document.querySelectorAll('.btn-primary-custom');
  saveButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      alert('Perubahan berhasil disimpan!');
    });
  });
});
