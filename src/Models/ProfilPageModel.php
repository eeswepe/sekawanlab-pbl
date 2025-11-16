<?php
declare(strict_types=1);

namespace App\Models;

use App\BaseModel;
use App\Database;
use PDO;

class ProfilPageModel extends BaseModel
{
    protected string $table = 'profil_page';
    protected string $primaryKey = 'id';
    protected array $fillable = [
        'slug',
        'page_title',
        'page_subtitle',
        'featured_image_url',
        'content_title',
        'content_subtitle',
        'last_updated',
        'created_at'
    ];

    public function __construct(?PDO $db = null)
    {
        $db = $db ?? Database::getConnection();
        parent::__construct($db);
    }

    // Buat halaman profil, kembalikan ID atau false
    public function createProfilPage(
        string $slug,
        string $pageTitle,
        string $pageSubtitle,
        ?string $featuredImageUrl,
        ?string $contentTitle,
        ?string $contentSubtitle
    ) {
        $data = [
            'slug' => $slug,
            'page_title' => $pageTitle,
            'page_subtitle' => $pageSubtitle,
            'featured_image_url' => $featuredImageUrl,
            'content_title' => $contentTitle,
            'content_subtitle' => $contentSubtitle
        ];

        $data = $this->filterFillable($data);
        $insertId = $this->create($data);

        // BaseModel::create() mengembalikan lastInsertId() (string) atau false
        return $insertId === false || $insertId === '' ? false : (int) $insertId;
    }

    // Ambil halaman profil berdasarkan slug
    public function getProfilPage(string $slug): ?array
    {
        $rows = $this->where(['slug' => $slug], null, 1);
        return $rows[0] ?? null;
    }

    // Ambil daftar slug + title untuk menu
    public function getProfilTitle(): array
    {
        $sql = "SELECT slug, page_title FROM {$this->table} ORDER BY id ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ambil semua halaman profil
    public function getAllProfilPages(): array
    {
        return $this->all();
    }

    // Ambil halaman profil berdasarkan id
    public function getProfilPageById(int $id): ?array
    {
        return $this->find($id) ?: null;
    }

    // Update halaman profil
    public function updateProfilPage(
        int $id,
        string $slug,
        string $pageTitle,
        string $pageSubtitle,
        ?string $featuredImageUrl,
        ?string $contentTitle,
        ?string $contentSubtitle
    ): bool {
        $data = [
            'slug' => $slug,
            'page_title' => $pageTitle,
            'page_subtitle' => $pageSubtitle,
            'featured_image_url' => $featuredImageUrl,
            'content_title' => $contentTitle,
            'content_subtitle' => $contentSubtitle
        ];

        $data = $this->filterFillable($data);
        $data['last_updated'] = date('Y-m-d H:i:s');
        return $this->update($id, $data);
    }

    // Hapus halaman profil
    public function deleteProfilPage(int $id): bool
    {
        return $this->delete($id);
    }
}
