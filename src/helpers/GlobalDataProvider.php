<?php

namespace App\Helpers;

use App\Models\ProfilPageModel;

/**
 * GlobalDataProvider
 * 
 * Menyediakan data global yang dibutuhkan di seluruh aplikasi
 * seperti menu navigasi, profil pages, dll.
 */
class GlobalDataProvider
{
    private static $profilModel = null;

    /**
     * Get profil pages untuk navigation menu
     * 
     * @return array
     */
    public static function getNavigationData(): array
    {
        if (self::$profilModel === null) {
            self::$profilModel = new ProfilPageModel();
        }

        return [
            'list-profil' => self::$profilModel->getProfilTitle()
        ];
    }

    /**
     * Clear cache (untuk testing atau reload data)
     */
    public static function clearCache(): void
    {
        self::$profilModel = null;
    }
}
