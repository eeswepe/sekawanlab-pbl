document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("joinForm");
  const fileInput = document.getElementById("cv");
  const fileName = document.getElementById("fileName");
  const fileNameText = document.getElementById("fileNameText");
  const submitButton = form.querySelector(".btn-submit");

  // Handle file input display
  fileInput.addEventListener("change", function (e) {
    if (this.files && this.files[0]) {
      const file = this.files[0];
      const maxSize = 5 * 1024 * 1024; // 5MB

      if (file.size > maxSize) {
        alert("Ukuran file terlalu besar. Maksimal 5MB");
        this.value = "";
        fileName.style.display = "none";
        return;
      }

      fileNameText.textContent = file.name;
      fileName.style.display = "flex";
    }
  });

  // Handle form submission
  form.addEventListener("submit", async function (e) {
    e.preventDefault();

    // Disable submit button
    submitButton.disabled = true;
    submitButton.innerHTML =
      '<i class="bi bi-hourglass-split me-2"></i>Mengirim...';

    try {
      const formData = new FormData();

      // Append form fields with correct database column names
      formData.append(
        "nama_lengkap",
        document.getElementById("namaLengkap").value,
      );
      formData.append("email", document.getElementById("email").value);
      formData.append("phone", document.getElementById("telepon").value);
      formData.append("nim", document.getElementById("nim").value);
      formData.append("prodi", document.getElementById("prodi").value);
      formData.append("semester", document.getElementById("semester").value);
      formData.append(
        "alasan_bergabung",
        document.getElementById("alasan").value,
      );
      formData.append("github_url", document.getElementById("github").value);

      // Append CV file
      const cvFile = document.getElementById("cv").files[0];
      if (cvFile) {
        formData.append("cv", cvFile);
      }

      // Send to server
      const response = await fetch("/join", {
        method: "POST",
        body: formData,
      });

      const result = await response.json();

      if (result.success) {
        // Show success message
        showAlert(
          "success",
          result.message ||
            "Pendaftaran berhasil dikirim! Tim kami akan menghubungi Anda segera.",
        );

        // Reset form
        form.reset();
        fileName.style.display = "none";

        // Scroll to top
        window.scrollTo({ top: 0, behavior: "smooth" });
      } else {
        showAlert(
          "error",
          result.message || "Gagal mengirim pendaftaran. Silakan coba lagi.",
        );
      }
    } catch (error) {
      console.error("Error:", error);
      showAlert("error", "Terjadi kesalahan. Silakan coba lagi.");
    } finally {
      // Re-enable submit button
      submitButton.disabled = false;
      submitButton.innerHTML =
        '<i class="bi bi-send me-2"></i>Submit Pendaftaran';
    }
  });

  // Show alert function
  function showAlert(type, message) {
    const alertDiv = document.createElement("div");
    alertDiv.className = `alert alert-${type === "success" ? "success" : "danger"} alert-dismissible fade show`;
    alertDiv.role = "alert";
    alertDiv.innerHTML = `
            <i class="bi bi-${type === "success" ? "check-circle" : "exclamation-circle"} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;

    const container = document.querySelector(".form-section .container");
    container.insertBefore(alertDiv, container.firstChild);

    // Auto dismiss after 5 seconds
    setTimeout(() => {
      alertDiv.remove();
    }, 5000);
  }

  // Phone number validation (Indonesian format)
  document.getElementById("telepon").addEventListener("input", function (e) {
    this.value = this.value.replace(/[^0-9]/g, "");
  });

  // NIM validation (numbers only)
  document.getElementById("nim").addEventListener("input", function (e) {
    this.value = this.value.replace(/[^0-9]/g, "");
  });
});
