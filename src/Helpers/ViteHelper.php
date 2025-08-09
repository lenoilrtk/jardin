<?php
// src/Helpers/ViteHelper.php
namespace App\Helpers;

use App\Config\App;

class ViteHelper
{
    private static $manifest = null;
    private static $isProduction = null;

    /**
     * Verificar si estamos en modo desarrollo
     */
    public static function isDev()
    {
        if (self::$isProduction === null) {
            // Si no existe manifest.json, estamos en desarrollo
            self::$isProduction = file_exists(App::path('public/assets/manifest.json'));
        }
        return !self::$isProduction;
    }

    /**
     * Obtener el manifest de Vite (solo en producción)
     */
    public static function getManifest()
    {
        if (self::$manifest === null && !self::isDev()) {
            $manifestPath = App::path('public/assets/manifest.json');
            if (file_exists($manifestPath)) {
                self::$manifest = json_decode(file_get_contents($manifestPath), true);
            }
        }
        return self::$manifest ?: [];
    }

    /**
     * Obtener URL de un asset
     */
    public static function asset($path)
    {
        if (self::isDev()) {
            // En desarrollo: usar servidor de Vite
            return "http://localhost:5173/{$path}";
        }

        // En producción: usar manifest para obtener archivo hasheado
        $manifest = self::getManifest();

        if (isset($manifest[$path])) {
            return App::url('public/assets/' . $manifest[$path]['file']);
        }

        // Fallback si no está en manifest
        return App::url('public/assets/' . ltrim($path, '/'));
    }

    /**
     * Renderizar tags HTML para assets
     */
    public static function renderAssets($entries = ['js/app.js', 'css/app.css'])
    {
        $html = '';

        if (self::isDev()) {
            // En desarrollo: cargar cliente de Vite para hot reload
            $html .= '<script type="module" src="http://localhost:5173/@vite/client"></script>' . "\n";

            foreach ($entries as $entry) {
                if (str_ends_with($entry, '.js')) {
                    $html .= '<script type="module" src="http://localhost:5173/' . $entry . '"></script>' . "\n";
                } elseif (str_ends_with($entry, '.css')) {
                    $html .= '<link rel="stylesheet" href="http://localhost:5173/' . $entry . '">' . "\n";
                }
            }
        } else {
            // En producción: usar archivos del manifest
            $manifest = self::getManifest();

            foreach ($entries as $entry) {
                if (isset($manifest[$entry])) {
                    $asset = $manifest[$entry];

                    if (str_ends_with($entry, '.js')) {
                        $html .= '<script type="module" src="' . App::url('public/assets/' . $asset['file']) . '"></script>' . "\n";

                        // Incluir CSS asociado si existe
                        if (isset($asset['css'])) {
                            foreach ($asset['css'] as $css) {
                                $html .= '<link rel="stylesheet" href="' . App::url('public/assets/' . $css) . '">' . "\n";
                            }
                        }
                    } elseif (str_ends_with($entry, '.css')) {
                        $html .= '<link rel="stylesheet" href="' . App::url('public/assets/' . $asset['file']) . '">' . "\n";
                    }
                }
            }
        }

        return $html;
    }
}
