<?php
require_once __DIR__ . '/../../vendor/autoload.php';
// logout.php
session_start();
// Vaciar todas las variables de sesión
$_SESSION = [];
// Destruir la sesión
session_destroy();
// Redirigir al login u otra página pública
header('Location: ' . app_path('public/Usuarios/login.php'));
exit;
