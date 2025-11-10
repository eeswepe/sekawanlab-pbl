<?php

use App\Router;
use App\Controllers\HomeController;
use App\Controllers\ProfilPageController;
use App\Controllers\PersonilController;

$router = new Router();

$router->get("/", HomeController::class, "index");
$router->get("/profil/{slug}", ProfilPageController::class, "show");
$router->get("/personil", PersonilController::class, "index");

$router->dispatch();
