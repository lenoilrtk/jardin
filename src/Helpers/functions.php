<?php
// src/Helpers/functions.php
use App\Config\App;
use App\Helpers\ViteHelper;

// ===== FUNCIONES BÁSICAS =====
if (!function_exists('url')) {
    function url($path = '')
    {
        return App::url($path);
    }
}

if (!function_exists('app_path')) {
    function app_path($path = '')
    {
        return App::path($path);
    }
}

if (!function_exists('base_url')) {
    function base_url()
    {
        return App::baseUrl();
    }
}

// ===== FUNCIONES DE VITE ===== ✅ NUEVAS
if (!function_exists('vite_asset')) {
    /**
     * URL de asset de Vite
     */
    function vite_asset($path)
    {
        return ViteHelper::asset($path);
    }
}

if (!function_exists('vite_assets')) {
    /**
     * Renderizar assets de Vite
     */
    function vite_assets($entries = ['js/app.js', 'css/app.css'])
    {
        return ViteHelper::renderAssets($entries);
    }
}

if (!function_exists('is_dev')) {
    /**
     * Verificar si estamos en desarrollo
     */
    function is_dev()
    {
        return ViteHelper::isDev();
    }
}
