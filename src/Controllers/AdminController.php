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

    public function renderBlogEdit($id)
    {
        $data = [
            "blog_id" => $id,
        ];

        $this->render("admin/admin_blog_edit", $data);
    }

    public function renderBlogCreate()
    {
        $this->render("admin/admin_blog_create");
    }

    public function renderProfilePages()
    {
        $this->render("admin/admin_profile-pages");
    }

    public function renderProfilePagesEdit($id)
    {
        $data = [
            "profile_page_id" => $id,
        ];

        $this->render("admin/admin_profile-page_edit", $data);
    }

    public function renderPersonilList()
    {
        $this->render("admin/admin_personil_list");
    }

    public function renderPersonilCreate()
    {
        $this->render("admin/admin_personil_create");
    }

    public function renderPersonilEdit($id)
    {
        $data = [
            "personil_id" => $id,
        ];

        $this->render("admin/admin_personil_edit", $data);
    }
    
    public function renderApplicationsList()
    {
        $this->render("admin/admin_applications-list");
    }

    public function renderApplicationView($id)
    {
        $data = [
            "application_id" => $id,
        ];

        $this->render("admin/admin_join_application_view", $data);
    }

    public function renderSiteSettings()
    {
        $this->render("admin/admin_site_settings");
    }
}