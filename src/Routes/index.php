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
use App\Middlewares\AdminMiddleware;
use App\Middlewares\PersonilMiddleware;

$router = new Router();

// Landing Pages
$router->get("/", HomeController::class, "index");
$router->get("/profil/{slug}", ProfilPageController::class, "show");
$router->get("/personil", PersonilController::class, "index");
$router->get("/blog", BlogController::class, "index");
$router->get("/join", JoinApplicationController::class, "index");
$router->post("/join", JoinApplicationController::class, "submitApplication");
$router->get("/personil-list", PersonilController::class, "index");

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
$router->get("/admin", AdminController::class, "dashboard")->middleware(AdminMiddleware::class);
$router->get("/admin/blog-list", AdminController::class, "blogList")->middleware(AdminMiddleware::class);
$router->get("/admin/blog/edit/{id}", AdminController::class, "renderBlogEdit")->middleware(AdminMiddleware::class);
$router->get("/admin/blog/create", AdminController::class, "renderBlogCreate")->middleware(AdminMiddleware::class);
$router->get("/admin/profil-pages", AdminController::class, "renderProfilePages")->middleware(AdminMiddleware::class);
$router->get("/admin/profil-page/edit/{id}", AdminController::class, "renderProfilePagesEdit")->middleware(AdminMiddleware::class);
$router->get("/admin/personil", AdminController::class, "renderPersonilList")->middleware(AdminMiddleware::class);
$router->get("/admin/personil/edit/{id}", AdminController::class, "renderPersonilEdit")->middleware(AdminMiddleware::class);
$router->get("/admin/personil/create", AdminController::class, "renderPersonilCreate")->middleware(AdminMiddleware::class);
$router->get("/admin/join-applications", AdminController::class, "renderApplicationsList")->middleware(AdminMiddleware::class);
$router->get("/admin/join-application/{id}", AdminController::class, "renderApplicationView")->middleware(AdminMiddleware::class);
$router->get("/admin/site-settings", AdminController::class, "renderSiteSettings")->middleware(AdminMiddleware::class);




// Personil
$router->get("/personil", PersonilController::class, "dashboard")->middleware(PersonilMiddleware::class);
$router->get("/personil/blog/create", PersonilController::class, "renderBlogCreate")->middleware(PersonilMiddleware::class);
$router->post("/personil/blog/create", PersonilController::class, "createBlog")->middleware(PersonilMiddleware::class);
$router->get("/personil/blog", PersonilController::class, "renderBlogList")->middleware(PersonilMiddleware::class);
$router->get("/personil/blog/edit/{id}", PersonilController::class, "renderBlogEdit")->middleware(PersonilMiddleware::class);
$router->post("/personil/blog/update/{id}", PersonilController::class, "updateBlog")->middleware(PersonilMiddleware::class);
$router->get("/personil/profile", PersonilController::class, "renderProfile")->middleware(PersonilMiddleware::class);
$router->get("/personil/profile/edit", PersonilController::class, "renderProfileEdit")->middleware(PersonilMiddleware::class);

// Personil API
$router->delete("/api/personil/blog/delete/{id}", PersonilController::class, "deleteBlog")->middleware(PersonilMiddleware::class);


$router->dispatch();
