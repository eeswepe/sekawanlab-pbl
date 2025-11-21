<?php 

namespace App\Controllers\Admin;

use App\Controller;
use App\Services\Admin\PersonilService;
use Exception;

/**
 * PersonilController
 * 
 * Handles admin personil management
 */
class PersonilController extends Controller
{
    private PersonilService $personilService;

    public function __construct()
    {
        $this->personilService = new PersonilService();
    }

    /**
     * Display personil list with filters
     * 
     * GET /admin/personil
     */
    public function index()
    {
        try {
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            
            // Service akan handle filtering
            $data = $this->personilService->getPersonilsWithFilters($_GET, $page);
            $data['filters'] = $_GET;
            
            $this->render("admin/personil/list", $data);
        } catch (Exception $e) {
            http_response_code(500);
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Display personil create form
     * 
     * GET /admin/personil/create
     */
    public function create()
    {
        $this->render("admin/personil/create");
    }

    /**
     * Store new personil
     * 
     * POST /admin/personil/create
     */
    public function store()
    {
        try {
            $personilId = $this->personilService->createPersonil($_POST, $_FILES);
            
            $this->jsonResponse([
                'success' => true,
                'message' => 'Personil berhasil dibuat',
                'personil_id' => $personilId
            ]);
        } catch (Exception $e) {
            $this->jsonResponse([
                'success' => false, 
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display personil edit form
     * 
     * GET /admin/personil/edit/{id}
     */
    public function edit($id)
    {
        try {
            $personil = $this->personilService->getPersonilForEdit($id);
            
            if (!$personil) {
                $this->redirect('/admin/personil');
            }
            
            // Parse skills JSON
            $personil['skills'] = !empty($personil['skills']) 
                ? json_decode($personil['skills'], true) 
                : [];
            
            $data = ['personil' => $personil];
            $this->render("admin/personil/edit", $data);
        } catch (Exception $e) {
            $this->redirect('/admin/personil');
        }
    }

    /**
     * Update personil
     * 
     * POST /admin/personil/update/{id}
     */
    public function update($id)
    {
        try {
            // Handle both JSON and multipart/form-data
            $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
            
            if (strpos($contentType, 'application/json') !== false) {
                // JSON request (backward compatibility)
                $rawData = json_decode(file_get_contents('php://input'), true);
                $this->personilService->updatePersonil($id, $rawData, []);
            } else {
                // FormData request (with file upload support)
                $this->personilService->updatePersonil($id, $_POST, $_FILES);
            }
            
            $this->jsonResponse([
                'success' => true, 
                'message' => 'Data personil berhasil diupdate'
            ]);
        } catch (Exception $e) {
            $this->jsonResponse([
                'success' => false, 
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Delete personil
     * 
     * DELETE /admin/personil/delete/{id}
     */
    public function delete($id)
    {
        try {
            $this->personilService->deletePersonil($id);
            
            $this->jsonResponse([
                'success' => true, 
                'message' => 'Personil berhasil dihapus'
            ]);
        } catch (Exception $e) {
            $this->jsonResponse([
                'success' => false, 
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
