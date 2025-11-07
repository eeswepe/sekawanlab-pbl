<?php

use App\Router;
use App\Models\UserModel;

$router = new Router();

$router->get("/", UserModel::class, "getAllUser");

$router->dispatch();
