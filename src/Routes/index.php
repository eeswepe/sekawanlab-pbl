<?php

use App\Router;
use App\Controllers\HomeController;
use App\Controllers\ProfilPageController;
use App\Controllers\PersonilController;
use App\Controllers\BlogController;
use App\Controllers\JoinApplicationController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Controllers\AdminController;

use App\Middlewares\GuestMiddleware;

$router = new Router();

// Landing Pages
$router->get("/", HomeController::class, "index");
$router->get("/profil/{slug}", ProfilPageController::class, "show");
$router->get("/personil", PersonilController::class, "index");
$router->get("/blog", BlogController::class, "index");
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

// Admin
$router->get("/admin", AdminController::class, "dashboard");
$router->get("/admin/blog-list", AdminController::class, "blogList");
$router->get("/admin/blog/edit/{id}", AdminController::class, "renderBlogEdit");
$router->get("/admin/blog/create", AdminController::class, "renderBlogCreate");
$router->get("/admin/profil-pages", AdminController::class, "renderProfilePages");
$router->get("/admin/profil-page/edit/{id}", AdminController::class, "renderProfilePagesEdit");
$router->get("/admin/personil", AdminController::class, "renderPersonilList");
$router->get("/admin/personil/edit/{id}", AdminController::class, "renderPersonilEdit");
$router->get("/admin/personil/create", AdminController::class, "renderPersonilCreate");
$router->get("/admin/join-applications", AdminController::class, "renderApplicationsList");
$router->get("/admin/join-application/{id}", AdminController::class, "renderApplicationView");
$router->get("/admin/site-settings", AdminController::class, "renderSiteSettings");




// Personil
$router->get("/personil", PersonilController::class, "index");
$router->get("/personil/dashboard", PersonilController::class, "dashboard");
$router->get("/personil/blog/create", PersonilController::class, "renderBlogCreate");
$router->get("/personil/blog", PersonilController::class, "renderBlogList");
$router->get("/personil/blog/edit/{id}", PersonilController::class, "renderBlogEdit");
$router->get("/personil/profile", PersonilController::class, "renderProfile");
$router->get("/personil/profile/edit", PersonilController::class, "renderProfileEdit");


$router->dispatch();
