document.addEventListener('DOMContentLoaded', () => {
  console.log("Personil Dashboard Loaded");

  // Simulasi interaksi tombol
  const quickButtons = document.querySelectorAll('.btn-primary-custom, .btn-outline-secondary');
  quickButtons.forEach(button => {
    button.addEventListener('click', () => {
      alert(`Kamu menekan tombol: "${button.innerText}"`);
    });
  });
});
