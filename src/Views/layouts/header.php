<!doctype html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Software Engineering Laboratory - Universitas</title>

        <!-- Bootstrap CSS -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
            rel="stylesheet"
        />

        <!-- Bootstrap Icons -->
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"
        />

        <!-- Google Fonts -->
        <link
            href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap"
            rel="stylesheet"
        />

        <!-- Custom CSS -->
        <link rel="stylesheet" href="/css/header.css" />
        <link rel="stylesheet" href="/css/<?php echo $page_css; ?>" />
        <link rel="stylesheet" href="/css/footer.css" />

        <style></style>
    </head>
    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <div class="logo-icon">SE</div>
                    <span>SE Laboratory</span>
                </a>
                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item dropdown">
                            <a
                                class="nav-link dropdown-toggle"
                                href="#"
                                id="profileDropdown"
                                role="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                Profile
                            </a>
                            <ul
                                class="dropdown-menu"
                                aria-labelledby="profileDropdown"
                            >
                                <?php foreach (
                                    $data["list-profil"]
                                    as $profil
                                ) {
                                    echo '<li><a class="dropdown-item" href="/profil/' .
                                        htmlspecialchars($profil["slug"]) .
                                        '">' .
                                        '<i class="bi bi-person-circle"></i>' .
                                        htmlspecialchars(
                                            $profil["page_title"],
                                        ) .
                                        "</a></li>";
                                } ?>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/personil-list"
                                >Personil</a
                            >
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/blog"
                                >Blog</a
                            >
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn-join" href="/join"
                                >Join Us</a
                            >
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
