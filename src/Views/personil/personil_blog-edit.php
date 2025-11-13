<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog Post - SE Laboratory</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/css/personil_blog-edit.css"> 
</head>
<body>

    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <a class="sidebar-brand" href="../dashboard.html">
                    <div class="logo-icon">SE</div>
                    <span>SE Laboratory</span>
                </a>
            </div>

            <ul class="sidebar-nav">
                <li class="sidebar-nav-item">
                    <a href="../dashboard.html" class="sidebar-nav-link">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="blog-list.html" class="sidebar-nav-link active">
                        <i class="bi bi-pencil-square"></i>
                        <span>Blog Management</span>
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="profile-view.html" class="sidebar-nav-link">
                        <i class="bi bi-person-circle"></i>
                        <span>My Profile</span>
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="#" class="sidebar-nav-link">
                        <i class="bi bi-file-person"></i>
                        <span>Profile Pages</span>
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="#" class="sidebar-nav-link">
                        <i class="bi bi-gear-fill"></i>
                        <span>Settings</span>
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="../../login.html" class="sidebar-nav-link">
                        <i class="bi bi-box-arrow-left"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div id="main-content">
            <nav id="topbar" class="navbar navbar-expand-lg">
                <div class="container-fluid d-flex justify-content-between align-items-center">

                    <div class="d-flex align-items-center">
                        <button class="btn sidebar-toggle sidebar-toggle-mobile" id="sidebarToggleMobile">
                            <i class="bi bi-list"></i>
                        </button>

                        <form class="d-none d-md-inline-block ms-2">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search...">
                                <button class="btn" style="background-color: var(--gold); color: white;" type="button">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <ul class="navbar-nav topbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link position-relative" href="#" id="alertsDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-bell-fill"></i>
                                <span class="notification-badge">3</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="alertsDropdown">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-text"></i> New Application</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-chat-dots"></i> New Comment</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Show All Alerts</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle profile-dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown">
                                <img src="https://via.placeholder.com/150/1a1a1a/FFFFFF?text=P" alt="Profile Picture">
                                <span class="d-none d-md-inline">Personil Name</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href="profile-view.html"><i class="bi bi-person-fill"></i> My Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-gear-fill"></i> Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="../../login.html"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>

                </div>
            </nav>
            <main class="content-fluid">
                <div class="page-header d-flex justify-content-between align-items-center">
                    <div>
                        <h1>Edit Blog Post</h1>
                        <p>Perbarui draf artikel Anda. (ID: #123)</p>
                    </div>
                </div>

                <form id="editBlogPostForm">
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title"><i class="bi bi-file-text me-2" style="color: var(--gold);"></i> Detail Post</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="postTitle" class="form-label">Judul Post</label>
                                        <input type="text" class="form-control" id="postTitle" value="Implementasi Microservices dengan Python dan Flask">
                                    </div>

                                    <div class="mb-3">
                                        <label for="postContent" class="form-label">Konten Artikel</label>
                                        <textarea class="form-control" id="postContent" rows="15">
Bab 1: Pengenalan Microservices...

Konsep Microservices telah merevolusi pengembangan perangkat lunak modern. Berbeda dengan arsitektur monolitik, Microservices membagi aplikasi menjadi layanan-layanan kecil yang independen dan dapat dideploy secara terpisah.

Dalam implementasi ini, kita menggunakan Python dan framework Flask yang ringan untuk membangun setiap layanan, memastikan skalabilitas dan pemeliharaan yang lebih baik.
                                        </textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="postCategory" class="form-label">Kategori</label>
                                        <select class="form-select" id="postCategory">
                                            <option value="Tech" selected>Teknologi</option>
                                            <option value="Research">Penelitian</option>
                                            <option value="Event">Event Lab</option>
                                        </select>
                                    </div>

                                    <div class="mb-0">
                                        <label for="tags" class="form-label">Tags (Pisahkan dengan koma)</label>
                                        <input type="text" class="form-control" id="tags" value="Python, Flask, Microservices, DevOps">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title"><i class="bi bi-clock-history me-2" style="color: var(--gold);"></i> Status & Jadwal</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="postStatus" class="form-label">Status Post</label>
                                        <select class="form-select" id="postStatus">
                                            <option value="draft" selected>Draft</option>
                                            <option value="review">Butuh Review</option>
                                            <option value="published" disabled>Published (Hanya Admin)</option>
                                        </select>
                                    </div>
                                    <div class="mb-0">
                                        <label for="lastSaved" class="form-label">Tanggal Terakhir Disimpan</label>
                                        <input type="text" class="form-control" id="lastSaved" value="2025-11-13 08:00 WIB" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title"><i class="bi bi-image-fill me-2" style="color: var(--gold);"></i> Gambar Unggulan</h5>
                                </div>
                                <div class="card-body">
                                    <img src="https://via.placeholder.com/400x200/444444/FFFFFF?text=Current+Image" alt="Current Featured Image" class="img-fluid rounded mb-3" id="imagePreview">
                                    <div class="mb-3">
                                        <label for="featuredImage" class="form-label">Upload Gambar Baru</label>
                                        <input class="form-control" type="file" id="featuredImage" accept="image/*" onchange="previewImage(event)">
                                    </div>
                                    <small class="text-muted">Rekomendasi rasio: 16:9 atau 2:1</small>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary-custom">
                                    <i class="bi bi-save-fill me-2"></i> Update Post
                                </button>
                                <button type="button" class="btn btn-danger" id="deleteButton" onclick="confirmDelete()">
                                    <i class="bi bi-trash-fill me-2"></i> Delete Draft
                                </button>
                                <a href="blog-list.html" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle-fill me-2"></i> Cancel
                                </a>
                            </div>

                        </div>
                    </div>
                </form>

            </main>
            <footer class="footer">
                <div class="container-fluid text-center">
                    <span class="text-muted">&copy; 2025 Software Engineering Laboratory. All rights reserved.</span>
                </div>
            </footer>
            </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="../../assets/js/personil_blog-edit.js"></script>

</body>
</html>