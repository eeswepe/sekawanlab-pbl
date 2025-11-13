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
$router->get("/logout", LoginController::class, "logout");
$router
    ->get("/register", RegisterController::class, "index")
    ->middleware(GuestMiddleware::class);
$router->post("/login", LoginController::class, "authenticate");
$router->post("/register", RegisterController::class, "register");

// Admin
$router->get("/admin", AdminController::class, "dashboard");
$router->get("/admin/blog-list", AdminController::class, "blogList");




$router->dispatch();
