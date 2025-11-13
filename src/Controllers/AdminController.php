<?php 

namespace App\Controllers;

use App\Controller;

class AdminController extends Controller
{
    public function dashboard()
    {
        $this->render("admin/dashboard");
    }

    public function blogList()
    {
        $this->render("admin/admin_blog_list");
    }
}