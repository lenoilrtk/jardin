<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['nivel'] != 1 && $_SESSION['nivel'] != 2) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración - Biblioteca Mágica</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ==============================
           ESTILOS PERSONALIZADOS
           Paleta coral / pastel
           ============================== */

        .header-gradient {
            background: linear-gradient(135deg, #ff9aa2 0%, #ff7b89 100%);
        }

        .text-coral {
            color: #b23a48 !important;
        }

        .text-coral-dark {
            color: #9a2a38 !important;
        }

        .text-coral-light {
            color: #ffb5bd !important;
        }

        .bg-coral-dark {
            background-color: #b23a48 !important;
        }

        .bg-coral-light {
            background-color: #fff0f2 !important;
        }

        .btn-coral {
            background-color: #ff7b89;
            border-color: #ff7b89;
            color: white;
        }

        .btn-coral:hover {
            background-color: #ff6b7a;
            border-color: #ff6b7a;
            color: white;
        }

        .search-icon {
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
        }

        .category-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        /* Colores pastel para las tarjetas */
        .bg-pink-light {
            background-color: #ffe0e3 !important;
        }

        .bg-purple-light {
            background-color: #f3e0ff !important;
        }

        .bg-orange-light {
            background-color: #ffe8d9 !important;
        }

        .text-pink {
            color: #ff7b89 !important;
        }

        .text-purple {
            color: #b36bcd !important;
        }

        .text-orange {
            color: #ff9a6b !important;
        }

        .icon-wrapper {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255,255,255,0.4);
            box-shadow: 0 4px 15px rgba(255, 123, 137, 0.2);
        }

        .admin-banner {
            background: linear-gradient(135deg, #fff0f2 0%, #ffebee 100%);
            border-bottom: 3px solid #ffccd1;
        }

        .admin-stats {
            background: linear-gradient(135deg, #fff0f2 0%, #ffebee 100%);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(255, 123, 137, 0.15);
        }

        body {
            background-color: #fffbfc;
        }

        .footer-gradient {
            background: linear-gradient(135deg, #ff7b89 0%, #b23a48 100%);
        }

        .stat-card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        /* Estilos para el dropdown de usuario */
        .dropdown-menu {
            border-radius: 12px;
            min-width: 250px;
            padding: 0;
            overflow: hidden;
        }

        .dropdown-header {
            padding: 15px;
            margin: 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .dropdown-item {
            padding: 10px 20px;
            transition: all 0.3s ease;
            border: none;
        }

        .dropdown-item:hover {
            background-color: #fff0f2;
            color: #b23a48;
            transform: translateX(5px);
        }

        .dropdown-item.text-danger:hover {
            background-color: #fee;
            color: #dc3545;
        }

        .dropdown-toggle::after {
            margin-left: 8px;
        }

        /* Animación para el botón de usuario */
        .btn-outline-light:hover .fa-user {
            transform: scale(1.1);
            transition: transform 0.3s ease;
        }

        /* Animación dropdown */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <!-- ==================================
         ENCABEZADO PRINCIPAL
         ================================== -->
    <header class="header-gradient py-3 shadow">
        <div class="container">
            <div class="row align-items-center">
                <!-- Logo + Título -->
                <div class="col-md-4 mb-3 mb-md-0 d-flex align-items-center">
                    <div class="bg-white/20 p-2 rounded-circle me-3">
                        <i class="fas fa-book-open fs-4 text-white"></i>
                    </div>
                    <div>
                        <h1 class="fs-2 fw-bold text-white mb-0">Biblioteca Mágica</h1>
                        <p class="text-white/90 mb-0 fs-6">Panel de Administración</p>
                    </div>
                </div>
                <!-- Barra de búsqueda interna -->
                <div class="col-md-5 mb-3 mb-md-0">
                    <div class="position-relative">
                        <i class="fas fa-search position-absolute search-icon text-muted"></i>
                        <input type="text" class="form-control rounded-pill py-2 ps-5" placeholder="Buscar en el sistema...">
                    </div>
                </div>
                <!-- Dropdown de usuario -->
                <div class="col-md-3 text-md-end">
                    <div class="dropdown d-inline-block me-2">
                        <button class="btn btn-outline-light dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="bg-white rounded-circle p-1 me-2">
                                <i class="fas fa-user text-coral fs-6"></i>
                            </div>
                            <span class="d-none d-md-inline">Administrador</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" aria-labelledby="userDropdown">
                            <li>
                                <div class="dropdown-header bg-coral-light">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-coral rounded-circle p-2 me-2">
                                            <i class="fas fa-user-shield text-white fs-6"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-coral fw-bold">Panel Admin</h6>
                                            <small class="text-muted">Biblioteca Mágica</small>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center py-2" href="index.html">
                                    <i class="fas fa-home me-3 text-coral"></i>
                                    <span>Ir al Inicio</span>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center py-2 text-danger" href="logout.php" onclick="return confirmLogout()">
                                    <i class="fas fa-sign-out-alt me-3"></i>
                                    <span class="fw-semibold">Cerrar Sesión</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- ==================================
         BANNER DE BIENVENIDA
         ================================== -->
    <div class="admin-banner py-4">
        <div class="container text-center">
            <h2 class="display-5 fw-bold text-coral mb-2">¡Bienvenido al Panel de Control!</h2>
            <p class="fs-5 text-coral-dark">Gestiona tu biblioteca de jardín de manera sencilla y eficiente</p>
        </div>
    </div>

    <!-- ==================================
         MÓDULOS DE ADMINISTRACIÓN
         ================================== -->
    <div class="container py-5">
        <h2 class="fs-1 fw-bold text-coral mb-4">Módulos de Administración</h2>
        <div class="row g-4">
            <!-- Libros -->
            <div class="col-md-4">
                <a href="ABM_libro.php" class="text-decoration-none">
                    <div class="category-card bg-pink-light rounded-4 p-4 text-center h-100">
                        <div class="icon-wrapper mb-3">
                            <i class="fas fa-book fs-1 text-pink"></i>
                        </div>
                        <h3 class="fs-4 fw-bold mb-2 text-coral">Gestión de Libros</h3>
                        <p class="text-muted">Añade, edita y organiza todos los libros de tu biblioteca. Controla disponibilidad y categorías.</p>
                        <div class="mt-3 d-flex justify-content-center gap-3">
                            <span class="badge bg-white text-pink px-3 py-2 rounded-pill">
                                <i class="fas fa-list me-1"></i> Catálogo
                            </span>
                            <span class="badge bg-white text-pink px-3 py-2 rounded-pill">
                                <i class="fas fa-check-circle me-1"></i> Disponibilidad
                            </span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Usuarios -->
            <div class="col-md-4">
                <a href="ABM_user.php" class="text-decoration-none">
                    <div class="category-card bg-purple-light rounded-4 p-4 text-center h-100">
                        <div class="icon-wrapper mb-3">
                            <i class="fas fa-users fs-1 text-purple"></i>
                        </div>
                        <h3 class="fs-4 fw-bold mb-2 text-coral">Gestión de Usuarios</h3>
                        <p class="text-muted">Registra nuevos usuarios, gestiona perfiles y controla el acceso a la biblioteca.</p>
                        <div class="mt-3 d-flex justify-content-center gap-3">
                            <span class="badge bg-white text-purple px-3 py-2 rounded-pill">
                                <i class="fas fa-user-plus me-1"></i> Registro
                            </span>
                            <span class="badge bg-white text-purple px-3 py-2 rounded-pill">
                                <i class="fas fa-id-card me-1"></i> Perfiles
                            </span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Movimientos -->
            <div class="col-md-4">
                <a href="movimientos.php" class="text-decoration-none">
                    <div class="category-card bg-orange-light rounded-4 p-4 text-center h-100">
                        <div class="icon-wrapper mb-3">
                            <i class="fas fa-exchange-alt fs-1 text-orange"></i>
                        </div>
                        <h3 class="fs-4 fw-bold mb-2 text-coral">Movimientos</h3>
                        <p class="text-muted">Registra préstamos, devoluciones y mantén un historial completo de actividades.</p>
                        <div class="mt-3 d-flex justify-content-center gap-3">
                            <span class="badge bg-white text-orange px-3 py-2 rounded-pill">
                                <i class="fas fa-book-reader me-1"></i> Préstamos
                            </span>
                            <span class="badge bg-white text-orange px-3 py-2 rounded-pill">
                                <i class="fas fa-history me-1"></i> Historial
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- ==================================
         ESTADÍSTICAS RÁPIDAS
         ================================== -->
    <div class="container mb-5">
        <div class="admin-stats p-4">
            <h3 class="fs-4 fw-bold text-coral mb-4 text-center">Resumen Rápido</h3>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="bg-white p-3 text-center stat-card">
                        <div class="stat-icon bg-pink-light text-pink mx-auto">
                            <i class="fas fa-book"></i>
                        </div>
                        <h4 class="fs-1 fw-bold text-coral mb-0">245</h4>
                        <p class="text-muted mb-0">Libros Totales</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-white p-3 text-center stat-card">
                        <div class="stat-icon bg-purple-light text-purple mx-auto">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <h4 class="fs-1 fw-bold text-coral mb-0">89</h4>
                        <p class="text-muted mb-0">Usuarios Activos</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-white p-3 text-center stat-card">
                        <div class="stat-icon bg-orange-light text-orange mx-auto">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4 class="fs-1 fw-bold text-coral mb-0">23</h4>
                        <p class="text-muted mb-0">Préstamos Activos</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================================
         PIE DE PÁGINA
         ================================== -->
    <footer class="footer-gradient text-white py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <h3 class="fs-4 fw-bold">Biblioteca Mágica - Administración</h3>
                    <p class="text-white-50 mb-0">Jardín de Infantes "Pequeños Exploradores"</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="btn btn-outline-light me-2">
                        <i class="fas fa-headset me-2"></i>Soporte Técnico
                    </a>
                    <a href="#" class="btn btn-outline-light">
                        <i class="fas fa-book me-2"></i>Manual de Usuario
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Funciones JavaScript -->
    <script>
        function confirmLogout() {
            return confirm('¿Estás seguro de que deseas cerrar sesión?');
        }

        function showProfile() {
            alert('Función de perfil en desarrollo');
        }

        function showSettings() {
            alert('Función de configuración en desarrollo');
        }

        // Animación suave para el dropdown
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownToggle = document.getElementById('userDropdown');
            const dropdownMenu = dropdownToggle.nextElementSibling;
            
            dropdownToggle.addEventListener('click', function() {
                setTimeout(() => {
                    dropdownMenu.style.animation = 'fadeInDown 0.3s ease';
                }, 10);
            });
        });
    </script>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
