<?php

namespace App\Controllers;

use App\Controller;

class DummyController extends Controller
{
    public function index()
    {
        $this->render("index");
    }
}
