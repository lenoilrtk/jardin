
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Biblioteca Mágica</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e0f2fe 0%, #e0f7fa 50%, #e8f5e8 100%);
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* Admin Header */
        .admin-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid #b2dfdb;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 0;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .admin-logo {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo-icon {
            background: linear-gradient(135deg, #26a69a, #00acc1);
            padding: 1rem;
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .logo-icon i {
            color: white;
            font-size: 1.5rem;
        }

        .logo-text h1 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #00695c;
            margin-bottom: 0.25rem;
        }

        .logo-text p {
            font-size: 0.875rem;
            color: #26a69a;
            margin: 0;
        }

        .admin-nav {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .nav-item {
            background: rgba(38, 166, 154, 0.1);
            border: 1px solid #b2dfdb;
            border-radius: 0.75rem;
            padding: 0.5rem 1rem;
            color: #26a69a;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-item:hover {
            background: #26a69a;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
        }

        .user-dropdown {
            position: relative;
        }

        .user-btn {
            background: linear-gradient(135deg, #26a69a, #00acc1);
            color: white;
            border: none;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .user-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.2);
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid #b2dfdb;
            border-radius: 1rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            min-width: 200px;
            margin-top: 0.5rem;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: #26a69a;
            text-decoration: none;
            transition: all 0.3s ease;
            border-bottom: 1px solid #f0f0f0;
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item:hover {
            background: rgba(38, 166, 154, 0.1);
            color: #00695c;
        }

        .dropdown-item.danger {
            color: #e53e3e;
        }

        .dropdown-item.danger:hover {
            background: rgba(229, 62, 62, 0.1);
        }

        /* Welcome Section */
        .welcome-section {
            padding: 3rem 0;
            text-align: center;
        }

        .welcome-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-radius: 1.5rem;
            padding: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid #b2dfdb;
            max-width: 48rem;
            margin: 0 auto;
        }

        .welcome-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #00695c;
            margin-bottom: 0.5rem;
        }

        .welcome-subtitle {
            font-size: 1.25rem;
            color: #26a69a;
            margin-bottom: 1.5rem;
        }

        .admin-badge {
            background: linear-gradient(135deg, #26a69a, #00acc1);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 2rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        /* Stats Section */
        .stats-section {
            padding: 2rem 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-radius: 1.5rem;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            border: 1px solid #b2dfdb;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .stat-icon {
            background: linear-gradient(135deg, #26a69a, #00acc1);
            width: 4rem;
            height: 4rem;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .stat-icon i {
            color: white;
            font-size: 1.5rem;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #00695c;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #26a69a;
            font-weight: 500;
        }

        /* Admin Modules */
        .modules-section {
            padding: 2rem 0;
        }

        .section-title {
            font-size: 2rem;
            font-weight: bold;
            color: #00695c;
            text-align: center;
            margin-bottom: 2rem;
        }

        .modules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .module-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-radius: 1.5rem;
            padding: 2rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            border: 1px solid #b2dfdb;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .module-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border-color: #26a69a;
        }

        .module-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .module-icon {
            background: linear-gradient(135deg, #26a69a, #00acc1);
            width: 4rem;
            height: 4rem;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .module-icon i {
            color: white;
            font-size: 1.5rem;
        }

        .module-title {
            font-size: 1.25rem;
            font-weight: bold;
            color: #00695c;
            margin-bottom: 0.25rem;
        }

        .module-subtitle {
            color: #26a69a;
            font-size: 0.875rem;
        }

        .module-description {
            color: #666;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .module-features {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .feature-tag {
            background: rgba(38, 166, 154, 0.1);
            color: #26a69a;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 500;
            border: 1px solid #b2dfdb;
        }

        /* Quick Actions */
        .quick-actions {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-radius: 1.5rem;
            padding: 2rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            border: 1px solid #b2dfdb;
            margin: 2rem 0;
        }

        .actions-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #00695c;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .action-btn {
            background: linear-gradient(135deg, #26a69a, #00acc1);
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 1rem;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.2);
            color: white;
        }

        /* Footer */
        .admin-footer {
            background: #26a69a;
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
        }

        .footer-content {
            background: #00695c;
            border-radius: 1.5rem;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-info h3 {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .footer-info p {
            color: #b2dfdb;
            margin: 0;
        }

        .footer-links {
            display: flex;
            gap: 1rem;
        }

        .footer-link {
            background: transparent;
            border: 1px solid white;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .footer-link:hover {
            background: white;
            color: #00695c;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                text-align: center;
            }

            .admin-nav {
                flex-wrap: wrap;
                justify-content: center;
            }

            .welcome-title {
                font-size: 2rem;
            }

            .modules-grid {
                grid-template-columns: 1fr;
            }

            .footer-content {
                flex-direction: column;
                text-align: center;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeInUp 0.6s ease forwards;
        }

        .fade-in:nth-child(1) { animation-delay: 0.1s; }
        .fade-in:nth-child(2) { animation-delay: 0.2s; }
        .fade-in:nth-child(3) { animation-delay: 0.3s; }
        .fade-in:nth-child(4) { animation-delay: 0.4s; }
    </style>
</head>
<body>
    <!-- Admin Header -->
    <header class="admin-header">
        <div class="container">
            <div class="header-content">
                <div class="admin-logo">
                    <div class="logo-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <div class="logo-text">
                        <h1>Panel de Administración</h1>
                        <p>Biblioteca Mágica</p>
                    </div>
                </div>

                <nav class="admin-nav">
                    <a href="index.php" class="nav-item">
                        <i class="fas fa-home"></i>
                        Inicio
                    </a>
                    <a href="#stats" class="nav-item">
                        <i class="fas fa-chart-bar"></i>
                        Estadísticas
                    </a>
                    <div class="user-dropdown">
                        <button class="user-btn" onclick="toggleDropdown()">
                            <i class="fas fa-user-shield"></i>
                            Administrador
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" id="userDropdown">
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-user-cog"></i>
                                Mi Perfil
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-cog"></i>
                                Configuración
                            </a>
                            <a href="logout.php" class="dropdown-item danger" onclick="return confirm('¿Cerrar sesión?')">
                                <i class="fas fa-sign-out-alt"></i>
                                Cerrar Sesión
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- Welcome Section -->
    <div class="welcome-section">
        <div class="container">
            <div class="welcome-card fade-in">
                <h2 class="welcome-title">¡Bienvenido al Panel de Control!</h2>
                <p class="welcome-subtitle">Gestiona tu biblioteca de manera eficiente y sencilla</p>
                <div class="admin-badge">
                    <i class="fas fa-shield-alt"></i>
                    Acceso de Administrador
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="stats-section" id="stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-card fade-in">
                    <div class="stat-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stat-number">245</div>
                    <div class="stat-label">Libros Totales</div>
                </div>
                <div class="stat-card fade-in">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-number">89</div>
                    <div class="stat-label">Usuarios Activos</div>
                </div>
                <div class="stat-card fade-in">
                    <div class="stat-icon">
                        <i class="fas fa-book-reader"></i>
                    </div>
                    <div class="stat-number">23</div>
                    <div class="stat-label">Préstamos Activos</div>
                </div>
                <div class="stat-card fade-in">
                    <div class="stat-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-number">156</div>
                    <div class="stat-label">Movimientos del Mes</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <h3 class="actions-title">Acciones Rápidas</h3>
                <div class="actions-grid">
                    <a href="ABM_libro.php" class="action-btn">
                        <i class="fas fa-plus"></i>
                        Agregar Libro
                    </a>
                    <a href="ABM_user.php" class="action-btn">
                        <i class="fas fa-user-plus"></i>
                        Nuevo Usuario
                    </a>
                    <a href="movimientos.php" class="action-btn">
                        <i class="fas fa-exchange-alt"></i>
                        Registrar Préstamo
                    </a>
                    <a href="#" class="action-btn">
                        <i class="fas fa-file-export"></i>
                        Generar Reporte
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Modules -->
    <div class="modules-section">
        <div class="container">
            <h2 class="section-title">Módulos de Administración</h2>
            <div class="modules-grid">
                <a href="ABM_libro.php" class="module-card fade-in">
                    <div class="module-header">
                        <div class="module-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <div>
                            <h3 class="module-title">Gestión de Libros</h3>
                            <p class="module-subtitle">Catálogo completo</p>
                        </div>
                    </div>
                    <p class="module-description">
                        Administra todo el catálogo de libros: agregar nuevos títulos, editar información, 
                        gestionar disponibilidad y organizar por categorías.
                    </p>
                    <div class="module-features">
                        <span class="feature-tag">Agregar libros</span>
                        <span class="feature-tag">Editar información</span>
                        <span class="feature-tag">Gestionar stock</span>
                        <span class="feature-tag">Categorías</span>
                    </div>
                </a>

                <a href="ABM_user.php" class="module-card fade-in">
                    <div class="module-header">
                        <div class="module-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <h3 class="module-title">Gestión de Usuarios</h3>
                            <p class="module-subtitle">Control de acceso</p>
                        </div>
                    </div>
                    <p class="module-description">
                        Registra nuevos usuarios, gestiona perfiles, controla niveles de acceso y 
                        mantén actualizada la información de contacto.
                    </p>
                    <div class="module-features">
                        <span class="feature-tag">Registro</span>
                        <span class="feature-tag">Perfiles</span>
                        <span class="feature-tag">Permisos</span>
                        <span class="feature-tag">Contactos</span>
                    </div>
                </a>

                <a href="movimientos.php" class="module-card fade-in">
                    <div class="module-header">
                        <div class="module-icon">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <div>
                            <h3 class="module-title">Control de Movimientos</h3>
                            <p class="module-subtitle">Préstamos y devoluciones</p>
                        </div>
                    </div>
                    <p class="module-description">
                        Registra préstamos, devoluciones, renovaciones y mantén un historial 
                        completo de todas las transacciones de la biblioteca.
                    </p>
                    <div class="module-features">
                        <span class="feature-tag">Préstamos</span>
                        <span class="feature-tag">Devoluciones</span>
                        <span class="feature-tag">Renovaciones</span>
                        <span class="feature-tag">Historial</span>
                    </div>
                </a>

                <a href="#" class="module-card fade-in">
                    <div class="module-header">
                        <div class="module-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div>
                            <h3 class="module-title">Reportes y Estadísticas</h3>
                            <p class="module-subtitle">Análisis de datos</p>
                        </div>
                    </div>
                    <p class="module-description">
                        Genera reportes detallados, visualiza estadísticas de uso, 
                        libros más populares y análisis de actividad de usuarios.
                    </p>
                    <div class="module-features">
                        <span class="feature-tag">Reportes</span>
                        <span class="feature-tag">Gráficos</span>
                        <span class="feature-tag">Exportar</span>
                        <span class="feature-tag">Análisis</span>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="admin-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-info">
                    <h3>
                        <i class="fas fa-cogs"></i>
                        Panel de Administración
                    </h3>
                    <p>Biblioteca Mágica - Jardín de Infantes "Pequeños Exploradores"</p>
                </div>
                <div class="footer-links">
                    <a href="#" class="footer-link">
                        <i class="fas fa-question-circle"></i>
                        Ayuda
                    </a>
                    <a href="#" class="footer-link">
                        <i class="fas fa-headset"></i>
                        Soporte
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const button = event.target.closest('.user-btn');
            
            if (!button && !dropdown.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });

        // Add fade-in animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe elements for animation
        document.querySelectorAll('.fade-in').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
