<?php
session_start();

require_once __DIR__ . '/../../../../vendor/autoload.php';
require_once app_path('public/conex.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesando Libro - Biblioteca Mágica</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

        /* Header Styles */
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

        .user-info {
            color: #26a69a;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Banner Section */
        .welcome-banner {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-radius: 1.5rem;
            padding: 2rem;
            margin: 2rem 0;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid #b2dfdb;
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
            margin: 0;
        }

        /* Result Container */
        .result-container {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-radius: 1.5rem;
            padding: 3rem;
            margin: 2rem auto;
            max-width: 700px;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid #b2dfdb;
        }

        /* Success Message */
        .success-message {
            background: rgba(16, 185, 129, 0.1);
            backdrop-filter: blur(8px);
            border: 2px solid #10b981;
            border-radius: 1.5rem;
            padding: 2rem;
            margin-bottom: 2rem;
            color: #065f46;
            position: relative;
            overflow: hidden;
        }

        .success-message::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #10b981, #34d399);
        }

        .success-message i {
            color: #10b981;
            margin-bottom: 1rem;
            animation: successPulse 2s infinite;
        }

        @keyframes successPulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        /* Error Message */
        .error-message {
            background: rgba(239, 68, 68, 0.1);
            backdrop-filter: blur(8px);
            border: 2px solid #ef4444;
            border-radius: 1.5rem;
            padding: 2rem;
            margin-bottom: 2rem;
            color: #dc2626;
            position: relative;
            overflow: hidden;
        }

        .error-message::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #ef4444, #f87171);
        }

        .error-message i {
            color: #ef4444;
            margin-bottom: 1rem;
            animation: errorShake 0.5s ease-in-out;
        }

        @keyframes errorShake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        .error-message ul {
            text-align: left;
            margin: 1rem 0;
            padding-left: 1.5rem;
        }

        .error-message li {
            margin-bottom: 0.5rem;
            position: relative;
        }

        .error-message li::before {
            content: '•';
            color: #ef4444;
            font-weight: bold;
            position: absolute;
            left: -1rem;
        }

        /* Book Preview */
        .book-preview {
            background: rgba(38, 166, 154, 0.1);
            backdrop-filter: blur(8px);
            border: 1px solid #b2dfdb;
            border-radius: 1.5rem;
            padding: 2rem;
            margin: 2rem 0;
            transition: all 0.3s ease;
        }

        .book-preview:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.1);
        }

        .book-preview img {
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
            border: 2px solid #b2dfdb;
            transition: all 0.3s ease;
        }

        .book-preview img:hover {
            transform: scale(1.05);
        }

        .book-info h5 {
            color: #00695c;
            font-weight: bold;
            margin-bottom: 1rem;
            font-size: 1.3rem;
        }

        .book-info p {
            color: #26a69a;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .book-info strong {
            color: #00695c;
        }

        /* Countdown */
        .countdown {
            background: rgba(38, 166, 154, 0.1);
            backdrop-filter: blur(8px);
            border: 1px solid #b2dfdb;
            border-radius: 1rem;
            padding: 1.5rem;
            margin: 2rem 0;
            font-size: 1.2rem;
            font-weight: bold;
            color: #00695c;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .countdown i {
            color: #26a69a;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .countdown-number {
            background: linear-gradient(135deg, #26a69a, #00acc1);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            font-size: 1.5rem;
            min-width: 3rem;
            display: inline-block;
            box-shadow: 0 5px 15px -5px rgba(0, 0, 0, 0.2);
        }

        /* Button Styles */
        .btn-teal {
            background: linear-gradient(135deg, #26a69a, #00acc1);
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0.5rem;
        }

        .btn-teal:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.2);
            color: white;
        }

        .btn-outline-teal {
            background: transparent;
            border: 2px solid #26a69a;
            color: #26a69a;
            padding: 0.75rem 2rem;
            border-radius: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0.5rem;
        }

        .btn-outline-teal:hover {
            background: #26a69a;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .btn-outline-danger {
            background: transparent;
            border: 2px solid #ef4444;
            color: #ef4444;
            padding: 0.75rem 2rem;
            border-radius: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0.5rem;
        }

        .btn-outline-danger:hover {
            background: #ef4444;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
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

        /* Responsive */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                text-align: center;
            }

            .welcome-title {
                font-size: 2rem;
            }

            .result-container {
                padding: 2rem;
                margin: 1rem;
            }

            .book-preview {
                padding: 1.5rem;
            }

            .footer-content {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="admin-header">
        <div class="container">
            <div class="header-content">
                <div class="admin-logo">
                    <div class="logo-icon">
                        <i class="fas fa-cog"></i>
                    </div>
                    <div class="logo-text">
                        <h1>Procesando Libro</h1>
                        <p>Biblioteca Mágica</p>
                    </div>
                </div>
                <div class="user-info">
                    <i class="fas fa-user-circle"></i>
                    Administrador
                </div>
            </div>
        </div>
    </header>

    <!-- Welcome Banner -->
    <div class="container">
        <div class="welcome-banner fade-in">
            <h2 class="welcome-title">Resultado de la Operación</h2>
            <p class="welcome-subtitle">Procesando la información del libro</p>
        </div>
    </div>

    <!-- Content -->
    <div class="container">
        <div class="result-container fade-in">
            <?php
            // Verificar que la petición sea POST
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                echo '<div class="error-message">
                        <i class="fas fa-exclamation-triangle fs-2"></i>
                        <h3>Acceso No Válido</h3>
                        <p>Esta página solo puede ser accedida mediante el formulario de añadir libro.</p>
                      </div>';
                echo '<a href="' . app_path("public/ABM/Libros/Añadir/ABM_libro_añadir.php") . '" class="btn-teal">
                        <i class="fas fa-arrow-left"></i>
                        Volver al Formulario
                      </a>';
                exit;
            }

            // Función para limpiar datos
            function limpiarDato($dato)
            {
                return htmlspecialchars(strip_tags(trim($dato)));
            }

            // Conexión a la base de datos
            include "./conex.php";

            // Procesar imagen subido por usuario
            $imagen = null;
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $tmp = $_FILES['imagen']['tmp_name'];
                $imagen = file_get_contents($tmp);
                if ($imagen === false || strlen($imagen) === 0) {
                    $imagen = null;
                }
            }

            // Si no se subió imagen, usar imagen por defecto
            if ($imagen === null) {
                $ruta_defecto = __DIR__ . app_path("resources/images/defecto.jpg");
                if (file_exists($ruta_defecto)) {
                    $imagen = file_get_contents($ruta_defecto);
                }
            }

            // Recoger campos
            $titulo       = limpiarDato($_POST['titulo'] ?? '');
            $autor        = limpiarDato($_POST['autor'] ?? '');
            $ilustrador   = limpiarDato($_POST['ilustrador'] ?? '');
            $editorial    = limpiarDato($_POST['editorial'] ?? '');
            $clasificacion = limpiarDato($_POST['clasificacion'] ?? '');
            $color        = limpiarDato($_POST['color'] ?? '');
            $resumen      = limpiarDato($_POST['resumen'] ?? '');

            // Validaciones
            $errores = [];
            if (!$titulo)        $errores[] = "El título es obligatorio";
            if (!$autor)         $errores[] = "El autor es obligatorio";
            if (!$ilustrador)    $errores[] = "El ilustrador es obligatorio";
            if (!$editorial)     $errores[] = "La editorial es obligatoria";
            if (!$clasificacion) $errores[] = "La clasificación es obligatoria";
            if (!$color)         $errores[] = "El color es obligatorio";
            if (!$resumen)       $errores[] = "El resumen es obligatorio";

            if ($errores) {
                echo '<div class="error-message">
                        <i class="fas fa-exclamation-triangle fs-2"></i>
                        <h3>Errores en los Datos</h3>
                        <ul>';
                foreach ($errores as $e) echo "<li>$e</li>";
                echo '</ul></div>';
                echo '<a href="javascript:history.back()" class="btn-outline-danger">
                        <i class="fas fa-arrow-left"></i>
                        Corregir
                      </a>';
                echo '<a href="' . app_path("public/ABM/Libros/ABM_libro.php") . '" class="btn-teal">
                        <i class="fas fa-book"></i>
                        Ver Libros
                      </a>';
                exit;
            }

            // Verificar conexión
            if ($conn->connect_error) {
                echo '<div class="error-message">
                        <i class="fas fa-database fs-2"></i>
                        <h3>Error de Conexión</h3>
                        <p>' . $conn->connect_error . '</p>
                      </div>';
                exit;
            }

            // Comprobar duplicados
            $chk = $conn->prepare("SELECT id FROM libros WHERE titulo=? AND autor=?");
            $chk->bind_param("ss", $titulo, $autor);
            $chk->execute();
            $res = $chk->get_result();
            if ($res->num_rows) {
                echo '<div class="error-message">
                        <i class="fas fa-copy fs-2"></i>
                        <h3>Libro Duplicado</h3>
                        <p>Ya existe un libro con ese título y autor en la base de datos.</p>
                      </div>';
                echo '<a href="javascript:history.back()" class="btn-outline-danger">
                        <i class="fas fa-arrow-left"></i>
                        Volver
                      </a>';
                echo '<a href="' . app_path("public/ABM/Libros/ABM_libro.php") . '" class="btn-teal">
                        <i class="fas fa-book"></i>
                        Ver Libros
                      </a>';
                exit;
            }
            $chk->close();

            // Insertar libro en la base de datos
            $ins = $conn->prepare("INSERT INTO libros 
                (titulo,autor,ilustrador,editorial,clasificacion,color,resumen,imagen) 
                VALUES (?,?,?,?,?,?,?,?)");
            $ins->bind_param(
                "ssssssss",
                $titulo,
                $autor,
                $ilustrador,
                $editorial,
                $clasificacion,
                $color,
                $resumen,
                $imagen
            );

            if ($ins->execute()) {
                // Registrar movimiento
                $usuario_id = $_SESSION['usuario_id'] ?? 0; // ID del usuario logueado
                $tabla_modif = 'libros';
                $campos_modif = 'titulo,autor,ilustrador,editorial,clasificacion,color,resumen';
                $valores_modif = "nulo,$titulo,nulo,$autor,nulo,$ilustrador,nulo,$editorial,nulo,$clasificacion,nulo,$color,nulo,$resumen";
                $mov = $conn->prepare("INSERT INTO movimientos(usuario_id,tabla_modif,campos_modif,valores_modif,fecha) VALUES (?,?,?,?,NOW())");
                $mov->bind_param("isss", $usuario_id, $tabla_modif, $campos_modif, $valores_modif);
                $mov->execute();
                $mov->close();

                echo '<div class="success-message">
                        <i class="fas fa-check-circle fs-2"></i>
                        <h3>¡Libro Añadido Correctamente!</h3>
                        <p>El libro ha sido registrado exitosamente en la base de datos.</p>
                      </div>';

                echo '<div class="book-preview">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-md-4 text-center mb-3 mb-md-0">';

                // Mostrar imagen desde BD o imagen por defecto
                echo '<img src="data:image/jpeg;base64,' . base64_encode($imagen) . '"'
                    . ' style="max-width:150px; max-height:200px;"'
                    . ' alt="Portada del libro">';

                echo '</div>
                            <div class="col-md-8 book-info text-start">
                                <h5>' . htmlspecialchars($titulo) . '</h5>
                                <p><strong>Autor:</strong> ' . htmlspecialchars($autor) . '</p>
                                <p><strong>Ilustrador:</strong> ' . htmlspecialchars($ilustrador) . '</p>
                                <p><strong>Editorial:</strong> ' . htmlspecialchars($editorial) . '</p>
                                <p><strong>Clasificación:</strong> ' . htmlspecialchars($clasificacion) . '</p>
                                <p><strong>Color:</strong> ' . htmlspecialchars($color) . '</p>
                            </div>
                        </div>s
                      </div>';

                echo '<div class="countdown">
                        <i class="fas fa-clock"></i>
                        Redirigiendo en <span class="countdown-number" id="cd">5</span> segundos...
                      </div>';

                echo '<div class="text-center">
                        <a href="' . app_path("public/ABM/Libros/ABM_libro.php") . '" class="btn-teal">
                            <i class="fas fa-book"></i>
                            Ver Todos los Libros
                        </a>
                        <a href="' . app_path("public/ABM/Libros/Añadir/ABM_libro_añadir.php") . '" class="btn-outline-teal">
                            <i class="fas fa-plus"></i>
                            Añadir Otro Libro
                        </a>
                      </div>';

                echo '<script>
                        let t=5, el=document.getElementById("cd");
                        const interval = setInterval(()=>{
                            t--; 
                            el.textContent=t;
                            if(t<=0) {
                                clearInterval(interval);
                                location="' . app_path("public/ABM/Libros/ABM_libro.php") . '";
                            }
                        },1000);
                      </script>';
            } else {
                echo '<div class="error-message">
                        <i class="fas fa-exclamation-triangle fs-2"></i>
                        <h3>Error al Añadir el Libro</h3>
                        <p>Ha ocurrido un error durante el proceso de inserción:</p>
                        <p><strong>Error:</strong> ' . $ins->error . '</p>
                      </div>';
                echo '<div class="text-center">
                        <a href="javascript:history.back()" class="btn-outline-danger">
                            <i class="fas fa-arrow-left"></i>
                            Intentar de Nuevo
                        </a>
                        <a href="' . app_path("public/ABM/Libros/ABM_libro.php") . '" class="btn-teal">
                            <i class="fas fa-book"></i>
                            Ver Libros
                        </a>
                      </div>';
            }

            $ins->close();
            $conn->close();
            ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="admin-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-info">
                    <h3>
                        <i class="fas fa-book"></i>
                        Biblioteca Mágica - Gestión
                    </h3>
                    <p>Jardín de Infantes "Pequeños Exploradores"</p>
                </div>
                <div class="footer-links">
                    <a href="#" class="footer-link">
                        <i class="fas fa-headset"></i>
                        Soporte Técnico
                    </a>
                    <a href="#" class="footer-link">
                        <i class="fas fa-book-open"></i>
                        Manual de Usuario
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
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
    </script>
</body>

</html>