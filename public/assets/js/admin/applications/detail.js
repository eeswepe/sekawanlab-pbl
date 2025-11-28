document.addEventListener("DOMContentLoaded", function () {
  // --- 1. Sidebar Toggle Logic ---
  const sidebar = document.getElementById("sidebar");
  const mainContent = document.getElementById("main-content");
  const toggleButton = document.getElementById("sidebarToggleMobile");

  function toggleSidebar() {
    sidebar.classList.toggle("toggled");
    mainContent.classList.toggle("toggled");
  }

  if (toggleButton) {
    toggleButton.addEventListener("click", toggleSidebar);
  }

  // --- 2. Quick Actions Handlers ---

  // Quick Accept
  document
    .getElementById("quickAccept")
    ?.addEventListener("click", async function () {
      const id = this.dataset.id;
      if (
        !confirm(
          "Terima aplikasi ini? Sistem akan membuat akun personil dengan password kosong."
        )
      )
        return;
      try {
        const response = await fetch(
          `/admin/join-application/update-status/${id}`,
          {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ status: "accepted" }),
          }
        );
        const result = await response.json();
        if (result.success) {
          const pid = result.personil_id ?? null;
          if (pid) {
            alert(
              `Aplikasi berhasil diterima. Akun personil dibuat (ID: ${pid}).`
            );
          } else {
            alert("Aplikasi berhasil diterima.");
          }
          location.reload();
        } else {
          alert(result.message || "Gagal memperbarui status");
        }
      } catch (error) {
        alert("Terjadi kesalahan: " + error.message);
      }
    });

  // Quick Reject
  document
    .getElementById("quickReject")
    ?.addEventListener("click", async function () {
      const id = this.dataset.id;
      if (!confirm("Tolak aplikasi ini?")) return;
      try {
        const response = await fetch(
          `/admin/join-application/update-status/${id}`,
          {
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
  document
    .getElementById("deleteApplication")
    ?.addEventListener("click", async function () {
      const id = this.dataset.id;
      if (
        !confirm("YAKIN hapus aplikasi ini PERMANEN? Tidak dapat dibatalkan.")
      )
        return;
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

  // Save New Status
  document
    .getElementById("updateStatusForm")
    ?.addEventListener("submit", async function (e) {
      e.preventDefault();
      const id = document.querySelector("[data-id]").dataset.id;
      const newStatus = document.getElementById("newStatus").value;

      if (newStatus === "accepted") {
        if (
          !confirm(
            "Terima aplikasi ini? Sistem akan membuat akun personil dengan password kosong."
          )
        )
          return;
      }

      try {
        const response = await fetch(
          `/admin/join-application/update-status/${id}`,
          {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ status: newStatus }),
          }
        );
        const result = await response.json();
        if (result.success) {
          const pid = result.personil_id ?? null;
          if (pid) {
            alert(
              `Status berhasil diperbarui. Akun personil dibuat (ID: ${pid}).`
            );
          } else {
            alert("Status berhasil diperbarui");
          }
          location.reload();
        } else {
          alert(result.message || "Gagal memperbarui status");
        }
      } catch (error) {
        alert("Terjadi kesalahan: " + error.message);
      }
    });

  // Save Admin Notes
  document
    .getElementById("adminNotesForm")
    ?.addEventListener("submit", async function (e) {
      e.preventDefault();
      const id = document.querySelector("[data-id]").dataset.id;
      const notes = document.getElementById("adminNotes").value;
      try {
        const response = await fetch(
          `/admin/join-application/update-notes/${id}`,
          {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ admin_notes: notes }),
          }
        );
        const result = await response.json();
        if (result.success) {
          alert("Catatan admin berhasil disimpan");
        } else {
          alert(result.message || "Gagal menyimpan catatan");
        }
      } catch (error) {
        alert("Terjadi kesalahan: " + error.message);
      }
    });

  // --- 3. CV Download & Preview ---
  const downloadBtn = document.getElementById("downloadCvBtn");
  if (downloadBtn) {
    downloadBtn.addEventListener("click", async function (e) {
      e.preventDefault();
      const path = this.dataset.cvPath;
      const name = this.dataset.cvName || "cv";
      try {
        const resp = await fetch("/" + path);
        if (!resp.ok) throw new Error("Gagal mengambil file");
        const blob = await resp.blob();
        const url = URL.createObjectURL(blob);
        const a = document.createElement("a");
        a.href = url;
        a.download = name;
        document.body.appendChild(a);
        a.click();
        a.remove();
        URL.revokeObjectURL(url);
      } catch (err) {
        alert("Gagal download CV: " + err.message);
      }
    });
  }

  const previewBtn = document.getElementById("previewCvBtn");
  if (previewBtn) {
    previewBtn.addEventListener("click", function () {
      const path = this.dataset.cvPath;
      const name = this.dataset.cvName || "CV Preview";
      const iframe = document.getElementById("cvPreviewIframe");
      const titleEl = document.getElementById("cvPreviewModalLabel");
      if (iframe) {
        iframe.src = "/" + path;
      }
      if (titleEl) {
        titleEl.textContent = "Preview CV: " + name;
      }
      const modalEl = document.getElementById("cvPreviewModal");
      if (modalEl) {
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
      }
    });
  }

  // --- 4. Assessment Summary (generate + render) ---
  function escapeHtml(str) {
    if (str === null || str === undefined) return '';
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
  }

  function renderBadgeForVerdict(verdictRaw) {
    if (!verdictRaw) return '';
    const verdict = String(verdictRaw).toLowerCase();
    let cls = 'bg-secondary text-white';
    if (["hire", "accept", "recommended"].includes(verdict)) cls = 'bg-success text-white';
    else if (["consider", "consideration"].includes(verdict)) cls = 'bg-warning text-dark';
    else if (["reject", "skip"].includes(verdict)) cls = 'bg-danger text-white';
    return `<div class="mb-3 text-center"><span class="badge ${cls} px-3 py-2"><i class="bi bi-circle-fill me-1" style="opacity:.85;font-size:.6rem"></i>${escapeHtml(String(verdictRaw).toUpperCase())}</span></div>`;
  }

  function renderList(title, items) {
    if (!Array.isArray(items) || items.length === 0) return '';
    const lis = items.map((r) => `<li>${escapeHtml(r)}</li>`).join('');
    return `<div class="mb-3"><h6 class="mb-2 small text-muted">${escapeHtml(title)}</h6><ul class="ps-3 mb-0 small">${lis}</ul></div>`;
  }

  function renderTopProjects(projects) {
    if (!Array.isArray(projects) || projects.length === 0) {
      return `<div class="text-center text-muted py-3 small"><i class="bi bi-folder2-open" style="font-size: 1.6rem;"></i><div class="mt-2">No notable projects found</div></div>`;
    }
    return projects.map((p, idx) => {
      const name = escapeHtml(p?.name ?? 'Untitled');
      const desc = escapeHtml(p?.description ?? '');
      const tech = Array.isArray(p?.tech_stack) ? p.tech_stack.map(t => `<span class="me-1 small">${escapeHtml(t)}</span>`).join('') : '';
      return `<div class="mb-3 p-3 border rounded" style="background:#fbfbfb;">
        <div class="d-flex">
          <div class="me-3"><span class="badge bg-secondary rounded-pill">${idx + 1}</span></div>
          <div class="flex-grow-1">
            <div class="d-flex justify-content-between"><h6 class="mb-1 small">${name}</h6></div>
            <p class="mb-2 small text-muted">${desc}</p>
            ${tech ? `<div class="small text-muted">${tech}</div>` : ''}
          </div>
        </div>
      </div>`;
    }).join('');
  }

  function renderSummaryHtml(summary) {
    const exec = summary?.executive_summary ? `<div class="card mb-4 border-1"><div class="card-header bg-light"><h6 class="mb-0 small"><i class="bi bi-clipboard-data me-2"></i>Executive Summary</h6></div><div class="card-body"><p class="mb-0">${escapeHtml(summary.executive_summary).replace(/\n/g, '<br>')}</p></div></div>` : '';

    const insight = summary?.recruiter_insight || {};
    const insightHtml = (insight && Object.keys(insight).length)
      ? `<div class="col-md-6"><div class="card h-100 border-1"><div class="card-header bg-light"><h6 class="mb-0 small"><i class="bi bi-person-check me-2"></i>Recruiter Insight</h6></div><div class="card-body">${renderBadgeForVerdict(insight.final_verdict)}${renderList('Reasons to Hire', insight.reasons_to_hire)}${renderList('Reasons to Skip', insight.reasons_to_skip)}</div></div></div>`
      : '';

    const projects = Array.isArray(summary?.top_projects) ? summary.top_projects : [];
    const projectsHtml = `<div class="col-md-6"><div class="card h-100 border-1"><div class="card-header bg-light"><h6 class="mb-0 small"><i class="bi bi-star me-2"></i>Top Projects</h6></div><div class="card-body">${renderTopProjects(projects)}</div></div></div>`;

    return `${exec}<div class="row g-3">${insightHtml}${projectsHtml}</div>`;
  }

  const viewSummaryBtn = document.getElementById("viewSummaryBtn");
  if (viewSummaryBtn) {
    viewSummaryBtn.addEventListener("click", async function () {
      const modalEl = document.getElementById("viewSummaryModal");
      const modal = modalEl ? new bootstrap.Modal(modalEl) : null;
      if (modal) modal.show();

      const id = this.dataset.id;
      const github = this.dataset.github || '';
      const cvPath = this.dataset.cvPath || '';

      const loading = document.getElementById('summaryLoading');
      const content = document.getElementById('summaryContent');
      const errorEl = document.getElementById('summaryError');
      if (content) content.innerHTML = '';
      if (errorEl) { errorEl.classList.add('d-none'); errorEl.textContent = ''; }
      if (loading) loading.classList.remove('d-none');

      try {
        const resp = await fetch(`/admin/join-application/generate-summary/${id}`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ github_url: github, cv_path: cvPath.startsWith('/') ? cvPath : '/' + cvPath })
        });
        const data = await resp.json();
        if (!data.success) throw new Error(data.message || 'Gagal menghasilkan ringkasan');
        const summary = data.data?.summary || {};
        if (content) content.innerHTML = renderSummaryHtml(summary);
      } catch (err) {
        if (errorEl) {
          errorEl.textContent = String(err.message || err);
          errorEl.classList.remove('d-none');
        } else {
          alert('Gagal memuat summary: ' + (err.message || err));
        }
      } finally {
        if (loading) loading.classList.add('d-none');
      }
    });
  }
});
