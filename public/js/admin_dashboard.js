document.addEventListener('DOMContentLoaded', () => {
  console.log('Admin Dashboard Loaded');

  // Contoh: menampilkan notifikasi interaktif
  const notification = document.querySelector('.notification');
  if (notification) {
    notification.addEventListener('click', () => {
      alert('Kamu memiliki 3 notifikasi baru!');
    });
  }

  // Tombol aksi cepat (simulasi)
  const quickButtons = document.querySelectorAll('.btn-primary-custom');
  quickButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      alert(`Kamu menekan tombol: "${btn.innerText}"`);
    });
  });
});
