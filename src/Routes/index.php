<?php

use App\Router;
use App\Controllers\DummyController;

$router = new Router();

$router->get("/", DummyController::class, "index");

$router->dispatch();
