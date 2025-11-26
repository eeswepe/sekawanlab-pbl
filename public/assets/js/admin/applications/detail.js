document.addEventListener("DOMContentLoaded", function () {
  // --- 1. Sidebar Toggle Logic (SB Admin 2 Style) ---
  const sidebar = document.getElementById("accordionSidebar");
  const toggleBtnDesktop = document.getElementById("sidebarToggle"); // Jika Anda menambahkan tombol toggle di sidebar nanti
  const toggleBtnMobile = document.getElementById("sidebarToggleTop");

  function toggleSidebar() {
    sidebar.classList.toggle("toggled");
  }

  if (toggleBtnMobile) {
    toggleBtnMobile.addEventListener("click", toggleSidebar);
  }
  
  if (toggleBtnDesktop) {
     toggleBtnDesktop.addEventListener("click", toggleSidebar);
  }

  // --- 2. Quick Actions Handlers (Sama seperti sebelumnya, logika tidak berubah) ---

  // Quick Accept
  document.getElementById("quickAccept")?.addEventListener("click", async function () {
      const id = this.dataset.id;
      if (!confirm("Terima aplikasi ini? Sistem akan membuat akun personil.")) return;
      
      try {
        const response = await fetch(`/admin/join-application/update-status/${id}`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ status: "accepted" }),
          }
        );
        const result = await response.json();
        if (result.success) {
          alert("Aplikasi berhasil diterima.");
          location.reload();
        } else {
          alert(result.message || "Gagal memperbarui status");
        }
      } catch (error) {
        alert("Terjadi kesalahan: " + error.message);
      }
    });

  // Quick Reject
  document.getElementById("quickReject")?.addEventListener("click", async function () {
      const id = this.dataset.id;
      if (!confirm("Tolak aplikasi ini?")) return;
      
      try {
        const response = await fetch(`/admin/join-application/update-status/${id}`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ status: "rejected" }),
          }
        );
        const result = await response.json();
        if (result.success) {
          alert("Aplikasi berhasil ditolak");
          location.reload();
        } else {
          alert(result.message || "Gagal memperbarui status");
        }
      } catch (error) {
        alert("Terjadi kesalahan: " + error.message);
      }
    });

  // Delete Application
  document.getElementById("deleteApplication")?.addEventListener("click", async function () {
      const id = this.dataset.id;
      if (!confirm("YAKIN hapus aplikasi ini PERMANEN?")) return;
      
      try {
        const response = await fetch(`/admin/join-application/delete/${id}`, {
          method: "DELETE",
        });
        const result = await response.json();
        if (result.success) {
          alert("Aplikasi berhasil dihapus");
          window.location.href = "/admin/join-applications";
        } else {
          alert(result.message || "Gagal menghapus aplikasi");
        }
      } catch (error) {
        alert("Terjadi kesalahan: " + error.message);
      }
    });

  // --- 3. CV Download & Preview (Sama seperti sebelumnya) ---
  const previewBtn = document.getElementById("previewCvBtn");
  if (previewBtn) {
    previewBtn.addEventListener("click", function () {
      const path = this.dataset.cvPath;
      const name = this.dataset.cvName || "CV Preview";
      const iframe = document.getElementById("cvPreviewIframe");
      const titleEl = document.getElementById("cvPreviewModalLabel");
      
      if (iframe) iframe.src = "/" + path;
      if (titleEl) titleEl.textContent = "Preview CV: " + name;
      
      const modalEl = document.getElementById("cvPreviewModal");
      if (modalEl) {
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
      }
    });
  }

    // AI Summary Modal Trigger
    const viewSummaryBtn = document.getElementById("viewSummaryBtn");
    if (viewSummaryBtn) {
        viewSummaryBtn.addEventListener("click", function () {
            const cvPath = this.dataset.cvPath;
            const cvName = this.dataset.cvName || "CV";
            
            if (!cvPath) {
                alert("CV file tidak ditemukan.");
                return;
            }
            
            // Show modal
            const modalElView = document.getElementById("viewSummaryModal");
            if (modalElView) {
                const modalView = new bootstrap.Modal(modalElView);
                modalView.show();
                
                // Update modal title
                const titleEl = document.getElementById("viewSummaryModalLabel");
                if (titleEl) {
                    titleEl.innerHTML = '<i class="bi bi-robot me-2"></i>AI Summary - ' + cvName;
                }
                
                // Start AI analysis
                performAISummary(cvPath);
            }
        });
    }

    // AI Summary Function
    async function performAISummary(cvPath) {
        const loadingState = document.getElementById("summaryLoadingState");
        const summaryContent = document.getElementById("summaryContent");
        const summaryError = document.getElementById("summaryError");
        const summaryResult = document.getElementById("summaryResult");
        const retryBtn = document.getElementById("retrySummary");
        
        // Reset states
        if (loadingState) loadingState.classList.remove("d-none");
        if (summaryContent) summaryContent.classList.add("d-none");
        if (summaryError) summaryError.classList.add("d-none");
        if (retryBtn) retryBtn.classList.add("d-none");
        
        try {
            // TODO: Replace with actual AI API endpoint
            // For now, we'll simulate AI analysis
            await new Promise(resolve => setTimeout(resolve, 2000)); // Simulate delay
            
            // Simulated AI response (replace with actual API call)
            const mockSummary = generateMockSummary();
            
            if (summaryResult) {
                summaryResult.innerHTML = mockSummary;
            }
            
            // Show success state
            if (loadingState) loadingState.classList.add("d-none");
            if (summaryContent) summaryContent.classList.remove("d-none");
            
        } catch (error) {
            console.error("AI Summary error:", error);
            
            // Show error state
            if (loadingState) loadingState.classList.add("d-none");
            if (summaryError) summaryError.classList.remove("d-none");
            if (retryBtn) retryBtn.classList.remove("d-none");
            
            const errorMsg = document.getElementById("summaryErrorMessage");
            if (errorMsg) {
                errorMsg.textContent = "Gagal menganalisis CV: " + error.message;
            }
        }
    }
    
    // Mock AI Summary Generator (replace with actual API)
    function generateMockSummary() {
        return `
            <div class="row g-4">
                <div class="col-md-6">
                    <h6 class="text-primary mb-3"><i class="bi bi-person-check me-2"></i>Profile Overview</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="bi bi-mortarboard me-2 text-info"></i>Fresh graduate dengan background IT</li>
                        <li class="mb-2"><i class="bi bi-code-slash me-2 text-info"></i>Memiliki pengalaman programming</li>
                        <li class="mb-2"><i class="bi bi-lightbulb me-2 text-info"></i>Menunjukkan minat dalam software engineering</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6 class="text-primary mb-3"><i class="bi bi-graph-up me-2"></i>Skills Assessment</h6>
                    <div class="mb-2">
                        <small class="text-muted">Programming Skills</small>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-info" style="width: 75%"></div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Academic Performance</small>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: 85%"></div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Project Experience</small>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-warning" style="width: 60%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12">
                    <h6 class="text-primary mb-3"><i class="bi bi-star me-2"></i>Recommendation</h6>
                    <div class="alert alert-success">
                        <strong>Rekomendasi: Diterima dengan catatan</strong><br>
                        Kandidat menunjukkan potensi yang baik untuk bergabung dengan lab. Disarankan untuk memberikan mentoring tambahan pada area pengembangan project yang lebih kompleks.
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <span class="badge bg-success">Komunikasi Baik</span>
                        <span class="badge bg-info">Technical Skills</span>
                        <span class="badge bg-warning">Butuh Mentoring</span>
                        <span class="badge bg-primary">Motivated</span>
                    </div>
                </div>
            </div>
        `;
    }
    
    // Retry Summary Button
    const retryBtn = document.getElementById("retrySummary");
    if (retryBtn) {
        retryBtn.addEventListener("click", function() {
            const viewSummaryBtn = document.getElementById("viewSummaryBtn");
            if (viewSummaryBtn && viewSummaryBtn.dataset.cvPath) {
                performAISummary(viewSummaryBtn.dataset.cvPath);
            }
        });
    }
});