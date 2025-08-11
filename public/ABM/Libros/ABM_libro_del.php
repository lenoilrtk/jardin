<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Libro - Biblioteca Mágica</title>

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

        .user-info {
            background: linear-gradient(135deg, #26a69a, #00acc1);
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        /* Main Content */
        .main-content {
            padding: 3rem 0;
        }

        .page-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .page-title h2 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #00695c;
            margin-bottom: 0.5rem;
        }

        .page-title p {
            font-size: 1.25rem;
            color: #26a69a;
        }

        /* Result Container */
        .result-container {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-radius: 1.5rem;
            padding: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid #b2dfdb;
            max-width: 800px;
            margin: 0 auto;
        }

        /* Message Styles */
        .confirmation-container {
            background: linear-gradient(135deg, #fff3cd, #ffeaa7);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            color: #856404;
            text-align: center;
            border: 2px solid #ffc107;
        }

        .success-message {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            color: #065f46;
            text-align: center;
            border: 2px solid #10b981;
        }

        .error-message {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            color: #dc2626;
            text-align: center;
            border: 2px solid #ef4444;
        }

        .message-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
        }

        .message-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        /* Book Info */
        .book-info {
            background: linear-gradient(135deg, #f3e8ff, #e0e7ff);
            border-radius: 1rem;
            padding: 1.5rem;
            margin: 1.5rem 0;
            border: 2px solid #dc2626;
        }

        .book-info h4 {
            color: #00695c;
            font-weight: bold;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .book-details {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 1rem;
            align-items: center;
        }

        .book-image {
            max-width: 120px;
            max-height: 160px;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            object-fit: cover;
        }

        .book-text {
            text-align: left;
        }

        .book-text h5 {
            font-weight: bold;
            color: #00695c;
            margin-bottom: 0.5rem;
        }

        .book-text p {
            margin-bottom: 0.25rem;
            color: #26a69a;
        }

        /* Buttons */
        .btn-action {
            background: linear-gradient(135deg, #26a69a, #00acc1);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            margin: 0.5rem;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.2);
            color: white;
        }

        .btn-secondary {
            background: rgba(108, 117, 125, 0.1);
            color: #6c757d;
            border: 1px solid #6c757d;
        }

        .btn-secondary:hover {
            background: #6c757d;
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc2626, #ef4444);
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #b91c1c, #dc2626);
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #059669, #047857);
        }

        /* Countdown */
        .countdown {
            font-size: 1.2rem;
            font-weight: bold;
            color: #26a69a;
            margin: 1rem 0;
            text-align: center;
        }

        /* Warning Animation */
        .warning-icon {
            color: #dc2626;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
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

            .page-title h2 {
                font-size: 2rem;
            }

            .book-details {
                grid-template-columns: 1fr;
                text-align: center;
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
    </style>
</head>

<body>
    <!-- Admin Header -->
    <header class="admin-header">
        <div class="container">
            <div class="header-content">
                <div class="admin-logo">
                    <div class="logo-icon">
                        <i class="fas fa-trash"></i>
                    </div>
                    <div class="logo-text">
                        <h1>Eliminar Libro</h1>
                        <p>Biblioteca Mágica</p>
                    </div>
                </div>

                <nav class="admin-nav">
                    <a href="<?= app_path("public/ABM/ABM_index.php") ?>" class="nav-item">
                        <i class="fas fa-home"></i>
                        Inicio
                    </a>
                    <div class="user-info">
                        <i class="fas fa-user-shield"></i>
                        Administrador
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- Page Title -->
    <div class="main-content">
        <div class="container">
            <div class="page-title fade-in">
                <h2>Gestión de Eliminación</h2>
                <p>Procesando solicitud de eliminación de libro</p>
            </div>

            <!-- Content -->
            <div class="result-container fade-in">
                <?php
                // Verificar que se haya proporcionado un ID
                if (!isset($_GET['id']) || empty($_GET['id'])) {
                    echo '<div class="error-message">
                            <i class="fas fa-exclamation-triangle message-icon"></i>
                            <h3 class="message-title">ID No Especificado</h3>
                            <p>No se ha proporcionado un ID válido para eliminar el libro.</p>
                          </div>';
                    echo '<a href="' . app_path("public/ABM/Libros/ABM_libro.php") . '" class="btn-action">
                            <i class="fas fa-arrow-left"></i>
                            Volver a la Lista
                          </a>';
                    exit;
                }

                // Validar que el ID sea numérico
                $libro_id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
                if ($libro_id === false || $libro_id <= 0) {
                    echo '<div class="error-message">
                            <i class="fas fa-exclamation-triangle message-icon"></i>
                            <h3 class="message-title">ID No Válido</h3>
                            <p>El ID proporcionado no es válido.</p>
                          </div>';
                    echo '<a href="./ABM_libro.php" class="btn-action">
                            <i class="fas fa-arrow-left"></i>
                            Volver a la Lista
                          </a>';
                    exit;
                }

                include "./conex.php";

                // Verificar conexión
                if ($conn->connect_error) {
                    echo '<div class="error-message">
                            <i class="fas fa-database message-icon"></i>
                            <h3 class="message-title">Error de Conexión</h3>
                            <p>No se pudo conectar a la base de datos: ' . $conn->connect_error . '</p>
                          </div>';
                    echo '<a href="./ABM_libro.php" class="btn-action">
                            <i class="fas fa-redo"></i>
                            Intentar de Nuevo
                          </a>';
                    exit;
                }

                // Verificar si se ha confirmado la eliminación
                $confirmado = isset($_GET['confirmar']) && $_GET['confirmar'] === 'si';

                if (!$confirmado) {
                    // Mostrar información del libro y pedir confirmación
                    $sqlInfo = "SELECT * FROM libros WHERE id = ?";
                    $stmtInfo = $conn->prepare($sqlInfo);
                    $stmtInfo->bind_param("i", $libro_id);
                    $stmtInfo->execute();
                    $resultInfo = $stmtInfo->get_result();

                    if ($resultInfo->num_rows === 0) {
                        echo '<div class="error-message">
                                <i class="fas fa-book-dead message-icon"></i>
                                <h3 class="message-title">Libro No Encontrado</h3>
                                <p>No se encontró ningún libro con el ID especificado.</p>
                              </div>';
                        echo '<a href="./ABM_libro.php" class="btn-action">
                                <i class="fas fa-arrow-left"></i>
                                Volver a la Lista
                              </a>';
                        $stmtInfo->close();
                        $conn->close();
                        exit;
                    }

                    $libro = $resultInfo->fetch_assoc();

                    echo '<div class="confirmation-container">
                            <i class="fas fa-exclamation-triangle warning-icon message-icon"></i>
                            <h3 class="message-title">⚠️ Confirmación de Eliminación ⚠️</h3>
                            <p style="font-size: 1.1rem; font-weight: bold;">¿Estás seguro de que quieres eliminar este libro?</p>
                            <p>Esta acción no se puede deshacer.</p>
                          </div>';

                    // Mostrar información del libro
                    echo '<div class="book-info">
                            <h4>
                                <i class="fas fa-book"></i>
                                Información del Libro a Eliminar
                            </h4>
                            <div class="book-details">
                                <img src="data:image/jpeg;base64,' . base64_encode($libro['imagen']) . '" alt="Portada" 
                                     class="book-image"
                                     onerror="this.src=\'/placeholder.svg?height=160&width=120\'">
                                <div class="book-text">
                                    <h5>ID: #' . $libro['id'] . ' - ' . htmlspecialchars($libro['titulo']) . '</h5>
                                    <p><strong>Autor:</strong> ' . htmlspecialchars($libro['autor']) . '</p>
                                    <p><strong>Ilustrador:</strong> ' . htmlspecialchars($libro['ilustrador']) . '</p>
                                    <p><strong>Editorial:</strong> ' . htmlspecialchars($libro['editorial']) . '</p>
                                    <p><strong>Clasificación:</strong> ' . htmlspecialchars($libro['clasificacion']) . '</p>
                                    <p><strong>Color:</strong> ' . htmlspecialchars($libro['color']) . '</p>
                                </div>
                            </div>
                          </div>';

                    // Botones de confirmación
                    echo '<div style="text-align: center;">
                            <a href="./ABM_libro.php" class="btn-action btn-secondary">
                                <i class="fas fa-times"></i>
                                Cancelar
                            </a>
                            <a href="./ABM_libro_del.php?id=' . $libro_id . '&confirmar=si" class="btn-action btn-danger">
                                <i class="fas fa-trash"></i>
                                Confirmar Eliminación
                            </a>
                          </div>';

                    $stmtInfo->close();
                } else {
                    // Proceder con la eliminación

                    // Primero obtener información del libro para mostrar después
                    $sqlInfo = "SELECT titulo, autor FROM libros WHERE id = ?";
                    $stmtInfo = $conn->prepare($sqlInfo);
                    $stmtInfo->bind_param("i", $libro_id);
                    $stmtInfo->execute();
                    $resultInfo = $stmtInfo->get_result();

                    if ($resultInfo->num_rows === 0) {
                        echo '<div class="error-message">
                                <i class="fas fa-book-dead message-icon"></i>
                                <h3 class="message-title">Libro No Encontrado</h3>
                                <p>El libro que intentas eliminar ya no existe en la base de datos.</p>
                              </div>';
                        echo '<a href="./ABM_libro.php" class="btn-action">
                                <i class="fas fa-arrow-left"></i>
                                Volver a la Lista
                              </a>';
                        $stmtInfo->close();
                        $conn->close();
                        exit;
                    }

                    $libroInfo = $resultInfo->fetch_assoc();
                    $stmtInfo->close();

                    // Realizar la eliminación con prepared statement
                    $sql = "DELETE FROM libros WHERE id = ?";
                    $stmt = $conn->prepare($sql);

                    if ($stmt === false) {
                        echo '<div class="error-message">
                                <i class="fas fa-exclamation-triangle message-icon"></i>
                                <h3 class="message-title">Error en la Consulta</h3>
                                <p>Error al preparar la consulta de eliminación: ' . $conn->error . '</p>
                              </div>';
                        echo '<a href="./ABM_libro.php" class="btn-action">
                                <i class="fas fa-arrow-left"></i>
                                Volver a la Lista
                              </a>';
                        $conn->close();
                        exit;
                    }

                    $stmt->bind_param("i", $libro_id);

                    if ($stmt->execute()) {
                        if ($stmt->affected_rows > 0) {
                            echo '<div class="success-message">
                                    <i class="fas fa-check-circle message-icon"></i>
                                    <h3 class="message-title">¡Libro Eliminado Exitosamente!</h3>
                                    <p>El libro "<strong>' . htmlspecialchars($libroInfo['titulo']) . '</strong>" de <strong>' . htmlspecialchars($libroInfo['autor']) . '</strong> ha sido eliminado correctamente del catálogo.</p>
                                    <p><strong>ID eliminado:</strong> #' . $libro_id . '</p>
                                  </div>';

                            echo '<div class="countdown">
                                    <i class="fas fa-clock"></i>
                                    Redirigiendo en <span id="countdown">5</span> segundos...
                                  </div>';

                            echo '<div style="text-align: center;">
                                    <a href="./ABM_libro.php" class="btn-action">
                                        <i class="fas fa-list"></i>
                                        Ver Lista de Libros
                                    </a>
                                    <a href="./ABM_libro_añadir.html" class="btn-action btn-success">
                                        <i class="fas fa-plus"></i>
                                        Añadir Nuevo Libro
                                    </a>
                                  </div>';

                            // JavaScript para redirección automática
                            echo '<script>
                                    let timeLeft = 5;
                                    const countdownElement = document.getElementById("countdown");
                                    
                                    const timer = setInterval(function() {
                                        timeLeft--;
                                        countdownElement.textContent = timeLeft;
                                        
                                        if (timeLeft <= 0) {
                                            clearInterval(timer);
                                            window.location.href = "./ABM_libro.php";
                                        }
                                    }, 1000);
                                  </script>';
                        } else {
                            echo '<div class="error-message">
                                    <i class="fas fa-question-circle message-icon"></i>
                                    <h3 class="message-title">Libro No Encontrado</h3>
                                    <p>No se encontró ningún libro con el ID especificado para eliminar.</p>
                                  </div>';
                            echo '<a href="./ABM_libro.php" class="btn-action">
                                    <i class="fas fa-arrow-left"></i>
                                    Volver a la Lista
                                  </a>';
                        }
                    } else {
                        echo '<div class="error-message">
                                <i class="fas fa-exclamation-triangle message-icon"></i>
                                <h3 class="message-title">Error al Eliminar</h3>
                                <p>Se produjo un error al intentar eliminar el libro de la base de datos.</p>
                                <p><strong>Error:</strong> ' . $stmt->error . '</p>
                              </div>';
                        echo '<div style="text-align: center;">
                                <a href="./ABM_libro.php" class="btn-action">
                                    <i class="fas fa-arrow-left"></i>
                                    Volver a la Lista
                                </a>
                                <a href="./ABM_libro_del.php?id=' . $libro_id . '" class="btn-action btn-danger">
                                    <i class="fas fa-redo"></i>
                                    Intentar de Nuevo
                                </a>
                              </div>';
                    }

                    $stmt->close();
                }

                $conn->close();
                ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="admin-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-info">
                    <h3>
                        <i class="fas fa-trash"></i>
                        Gestión de Eliminación
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
        // Add fade-in animation on load
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.fade-in');
            elements.forEach((el, index) => {
                setTimeout(() => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 200);
            });
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
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