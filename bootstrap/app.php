<?php
// bootstrap/app.php
use App\Config\App;

// Inicializar la aplicación
App::init();

// Cargar funciones helper
require_once App::path('src/Helpers/functions.php');
