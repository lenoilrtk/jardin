<?php
// src/Config/App.php
namespace App\Config;

class App
{
    private static $basePath;
    private static $baseUrl;
    private static $initialized = false;

    public static function init()
    {
        if (self::$initialized) {
            return;
        }

        // Detectar ruta base del proyecto
        self::$basePath = dirname(dirname(__DIR__));

        // Detectar URL base automáticamente
        self::$baseUrl = self::detectBaseUrl();

        self::$initialized = true;

        // Definir constantes globales
        define('BASE_PATH', self::$basePath);
        define('BASE_URL', self::$baseUrl);
    }

    private static function detectBaseUrl()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $script = dirname($_SERVER['SCRIPT_NAME']);

        // Si estamos en /public, subir un nivel
        if (basename($script) === 'public') {
            $script = dirname($script);
        }

        // Limpiar barras finales
        $script = rtrim($script, '/\\');

        return $protocol . '://' . $host . $script;
    }

    public static function url($path = '')
    {
        if (empty($path)) {
            return self::$baseUrl;
        }

        $path = ltrim($path, '/');
        return self::$baseUrl . '/' . $path;
    }

    public static function path($path = '')
    {
        if (empty($path)) {
            return self::$basePath;
        }

        $path = ltrim(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path), '/\\');
        return self::$basePath . DIRECTORY_SEPARATOR . $path;
    }

    public static function baseUrl()
    {
        return self::$baseUrl;
    }
}
