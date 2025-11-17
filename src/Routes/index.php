<?php

use App\Router;
use App\Controllers\HomeController;
use App\Controllers\ProfilPageController;
use App\Controllers\PersonilController;
use App\Controllers\BlogController;
use App\Controllers\JoinApplicationController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;

// Admin Controllers
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\BlogController as AdminBlogController;
use App\Controllers\Admin\PersonilController as AdminPersonilController;
use App\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Controllers\Admin\ProfilePageController as AdminProfilePageController;

use App\Middlewares\GuestMiddleware;
use App\Middlewares\AdminMiddleware;
use App\Middlewares\PersonilMiddleware;

$router = new Router();

// Landing Pages
$router->get("/", HomeController::class, "index");
$router->get("/profil/{slug}", ProfilPageController::class, "show");
$router->get("/personil", PersonilController::class, "index");
$router->get("/personil/detail/{id}", PersonilController::class, "showById");
$router->get("/personil-list", PersonilController::class, "index");
$router->get("/blog", BlogController::class, "index");
$router->get("/blog/{slug}", BlogController::class, "showBySlug");
$router->get("/join", JoinApplicationController::class, "index");
$router->post("/join", JoinApplicationController::class, "submitApplication");

// Authentication
$router
    ->get("/login", LoginController::class, "index")
    ->middleware(GuestMiddleware::class);
$router->post("/login", LoginController::class, "authenticate");
$router->get("/logout", LoginController::class, "logout");
$router
    ->get("/register", RegisterController::class, "index")
    ->middleware(GuestMiddleware::class);
$router->post("/register", RegisterController::class, "register");

// ===== ADMIN ROUTES =====
// Dashboard
$router->get("/admin", DashboardController::class, "index")->middleware(AdminMiddleware::class);

// Blog Management
$router->get("/admin/blog-list", AdminBlogController::class, "index")->middleware(AdminMiddleware::class);
$router->get("/admin/blog/create", AdminBlogController::class, "create")->middleware(AdminMiddleware::class);
$router->post("/admin/blog/create", AdminBlogController::class, "store")->middleware(AdminMiddleware::class);
$router->get("/admin/blog/edit/{id}", AdminBlogController::class, "edit")->middleware(AdminMiddleware::class);
$router->post("/admin/blog/update/{id}", AdminBlogController::class, "update")->middleware(AdminMiddleware::class);
$router->delete("/admin/blog/delete/{id}", AdminBlogController::class, "delete")->middleware(AdminMiddleware::class);

// Profile Pages Management
$router->get("/admin/profil-pages", AdminProfilePageController::class, "index")->middleware(AdminMiddleware::class);
$router->get("/admin/profil-pages/create", AdminProfilePageController::class, "create")->middleware(AdminMiddleware::class);
$router->post("/admin/profil-pages/create", AdminProfilePageController::class, "store")->middleware(AdminMiddleware::class);
$router->get("/admin/profil-pages/edit/{id}", AdminProfilePageController::class, "edit")->middleware(AdminMiddleware::class);
$router->post("/admin/profil-pages/update/{id}", AdminProfilePageController::class, "update")->middleware(AdminMiddleware::class);

// Personil Management
$router->get("/admin/personil", AdminPersonilController::class, "index")->middleware(AdminMiddleware::class);
$router->get("/admin/personil/create", AdminPersonilController::class, "create")->middleware(AdminMiddleware::class);
$router->post("/admin/personil/create", AdminPersonilController::class, "store")->middleware(AdminMiddleware::class);
$router->get("/admin/personil/edit/{id}", AdminPersonilController::class, "edit")->middleware(AdminMiddleware::class);
$router->post("/admin/personil/update/{id}", AdminPersonilController::class, "update")->middleware(AdminMiddleware::class);
$router->delete("/admin/personil/delete/{id}", AdminPersonilController::class, "delete")->middleware(AdminMiddleware::class);

// Applications Management
$router->get("/admin/join-applications", AdminApplicationController::class, "index")->middleware(AdminMiddleware::class);
$router->get("/admin/join-application/{id}", AdminApplicationController::class, "show")->middleware(AdminMiddleware::class);
$router->delete("/admin/join-application/delete/{id}", AdminApplicationController::class, "delete")->middleware(AdminMiddleware::class);
$router->post("/admin/join-application/update-status/{id}", AdminApplicationController::class, "updateStatus")->middleware(AdminMiddleware::class);
$router->post("/admin/join-application/update-notes/{id}", AdminApplicationController::class, "updateNotes")->middleware(AdminMiddleware::class);

// ===== PERSONIL ROUTES =====
$router->get("/personil/dashboard", PersonilController::class, "dashboard")->middleware(PersonilMiddleware::class);
$router->get("/personil/blog/create", PersonilController::class, "renderBlogCreate")->middleware(PersonilMiddleware::class);
$router->post("/personil/blog/create", PersonilController::class, "createBlog")->middleware(PersonilMiddleware::class);
$router->get("/personil/blog", PersonilController::class, "renderBlogList")->middleware(PersonilMiddleware::class);
$router->get("/personil/blog/edit/{id}", PersonilController::class, "renderBlogEdit")->middleware(PersonilMiddleware::class);
$router->post("/personil/blog/update/{id}", PersonilController::class, "updateBlog")->middleware(PersonilMiddleware::class);
$router->get("/personil/profile", PersonilController::class, "renderProfile")->middleware(PersonilMiddleware::class);
$router->get("/personil/profile/edit", PersonilController::class, "renderProfileEdit")->middleware(PersonilMiddleware::class);
$router->post("/personil/profile/update", PersonilController::class, "updateProfile")->middleware(PersonilMiddleware::class);

// Personil API
$router->delete("/api/personil/blog/delete/{id}", PersonilController::class, "deleteBlog")->middleware(PersonilMiddleware::class);


$router->dispatch();
