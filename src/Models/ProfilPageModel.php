<?php
namespace App\Models;

use App\Database;
use \PDO;

class ProfilPageModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function createProfilPage(
        $slug,
        $pageTitle,
        $pageSubtitle,
        $featuredImageUrl,
        $contentTitle,
        $contentSubtitle,
    ) {
        $stmt = $this->db->prepare(
            "INSERT INTO profil_page (slug, page_title, page_subtitle, featured_image_url, content_title, content_subtitle) VALUES (?, ?, ?, ?, ?, ?)",
        );
        $stmt->execute([
            $slug,
            $pageTitle,
            $pageSubtitle,
            $featuredImageUrl,
            $contentTitle,
            $contentSubtitle,
        ]);
        return $this->db->lastInsertId();
    }

    public function getProfilPage($slug)
    {
        $stmt = $this->db->prepare("SELECT * FROM profil_page WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getProfilTitle()
    {
        $stmt = $this->db->prepare("SELECT slug, page_title FROM profil_page ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateProfilPage(
        $id,
        $slug,
        $pageTitle,
        $pageSubtitle,
        $featuredImageUrl,
        $contentTitle,
        $contentSubtitle,
    ) {
        $stmt = $this->db->prepare(
            "UPDATE profil_page SET slug = ?, page_title = ?, page_subtitle = ?, featured_image_url = ?, content_title = ?, content_subtitle = ? WHERE id = ?",
        );
        $stmt->execute([
            $slug,
            $pageTitle,
            $pageSubtitle,
            $featuredImageUrl,
            $contentTitle,
            $contentSubtitle,
            $id,
        ]);
        return $stmt->rowCount();
    }

    public function deleteProfilPage($id)
    {
        $stmt = $this->db->prepare("DELETE FROM profil_page WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }
}
