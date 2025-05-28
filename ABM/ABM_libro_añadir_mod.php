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
        /* Estilos personalizados basados en el diseño original */
        .header-gradient {
            background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
        }
        .text-purple { color: #8b5cf6 !important; }
        .text-purple-dark { color: #6d28d9 !important; }
        .text-purple-light { color: #c4b5fd !important; }
        .bg-purple-dark { background-color: #6d28d9 !important; }
        .btn-purple {
            background-color: #8b5cf6;
            border-color: #8b5cf6;
            color: white;
        }
        .btn-purple:hover {
            background-color: #7c3aed;
            border-color: #7c3aed;
            color: white;
        }
        .result-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            padding: 40px;
            margin: 50px auto;
            max-width: 600px;
            text-align: center;
        }
        .success-message {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            color: #065f46;
        }
        .error-message {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            color: #dc2626;
        }
        .book-preview {
            background: linear-gradient(135deg, #f3e8ff 0%, #e0e7ff 100%);
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
        }
        .countdown {
            font-size: 1.2em;
            font-weight: bold;
            color: #8b5cf6;
        }
        .btn-action {
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            margin: 10px;
        }
        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <header class="header-gradient py-3 shadow">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 d-flex align-items-center">
                    <div class="bg-white p-2 rounded-circle me-3">
                        <i class="fas fa-cog fs-4 text-purple"></i>
                    </div>
                    <h1 class="fs-2 fw-bold text-white mb-0">Procesando Libro</h1>
                </div>
                <div class="col-md-6 text-md-end">
                    <span class="text-white fw-bold">
                        <i class="fas fa-user-circle me-2"></i>¡Hola, Lionel!
                    </span>
                </div>
            </div>
        </div>
    </header>

    <!-- Banner principal -->
    <div class="bg-warning py-4">
        <div class="container text-center">
            <h2 class="display-5 fw-bold text-purple mb-2">Resultado de la Operación</h2>
            <p class="fs-5 text-purple-dark">Procesando la información del libro</p>
        </div>
    </div>

    <!-- Contenido -->
    <div class="container">
        <div class="result-container">
            <?php
            // Verificar que la petición sea POST
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                echo '<div class="error-message">
                        <i class="fas fa-exclamation-triangle fs-2 mb-3"></i>
                        <h3>Acceso No Válido</h3>
                        <p>Esta página solo puede ser accedida mediante el formulario de añadir libro.</p>
                      </div>';
                echo '<a href="./ABM_libro_añadir.html" class="btn btn-purple btn-action">Volver al Formulario</a>';
                exit;
            }

            // Función para limpiar datos
            function limpiarDato($dato) {
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
                $ruta_defecto = __DIR__ . '/../images/defecto.jpg';
                if (file_exists($ruta_defecto)) {
                    $imagen = file_get_contents($ruta_defecto);
                }
            }

            // Recoger campos
            $titulo       = limpiarDato($_POST['titulo'] ?? '');
            $autor        = limpiarDato($_POST['autor'] ?? '');
            $ilustrador   = limpiarDato($_POST['ilustrador'] ?? '');
            $editorial    = limpiarDato($_POST['editorial'] ?? '');
            $clasificacion= limpiarDato($_POST['clasificacion'] ?? '');
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
                echo '<div class="error-message"><i class="fas fa-exclamation-triangle fs-2 mb-3"></i><h3>Errores en los Datos</h3><ul class="text-start">';
                foreach ($errores as $e) echo "<li>$e</li>";
                echo '</ul></div>';
                echo '<a href="javascript:history.back()" class="btn btn-outline-danger btn-action">Corregir</a> ';
                echo '<a href="./ABM_libro.php" class="btn btn-purple btn-action">Ver Libros</a>';
                exit;
            }

            // Verificar conexión
            if ($conn->connect_error) {
                echo '<div class="error-message"><i class="fas fa-database fs-2 mb-3"></i><h3>Error de Conexión</h3>
                      <p>' . $conn->connect_error . '</p></div>';
                exit;
            }

            // Comprobar duplicados
            $chk = $conn->prepare("SELECT id FROM libros WHERE titulo=? AND autor=?");
            $chk->bind_param("ss", $titulo, $autor);
            $chk->execute();
            $res = $chk->get_result();
            if ($res->num_rows) {
                echo '<div class="error-message"><i class="fas fa-copy fs-2 mb-3"></i><h3>Libro Duplicado</h3>
                      <p>Ya existe un libro con ese título y autor.</p></div>';
                echo '<a href="javascript:history.back()" class="btn btn-outline-danger btn-action">Volver</a>';
                exit;
            }
            $chk->close();

            // Insertar libro en la base de datos
            $ins = $conn->prepare("INSERT INTO libros
                (titulo,autor,ilustrador,editorial,clasificacion,color,resumen,imagen)
                VALUES (?,?,?,?,?,?,?,?)");
            $ins->bind_param("ssssssss",
                $titulo, $autor, $ilustrador,
                $editorial, $clasificacion,
                $color, $resumen, $imagen
            );

            if ($ins->execute()) {
                echo '<div class="success-message"><i class="fas fa-check-circle fs-2 mb-3"></i>
                      <h3>Libro Añadido Correctamente</h3>
                      <div class="book-preview row align-items-center justify-content-center">
                        <div class="col-md-4 text-center">';
                // Mostrar imagen desde BD o imagen por defecto
                echo '<img src="data:image/jpeg;base64,' . base64_encode($imagen) . '"'
                   . ' style="max-width:120px; max-height:160px; border-radius:10px; box-shadow:0 4px 8px rgba(0,0,0,0.1);"'
                   . ' alt="Portada">';

                echo '</div><div class="col-md-8 text-start">
                        <h5 class="fw-bold text-purple">'.htmlspecialchars($titulo).'</h5>
                        <p><strong>Autor:</strong> '.htmlspecialchars($autor).'</p>
                        <p><strong>Ilustrador:</strong> '.htmlspecialchars($ilustrador).'</p>
                        <p><strong>Editorial:</strong> '.htmlspecialchars($editorial).'</p>
                        <p><strong>Clasificación:</strong> '.htmlspecialchars($clasificacion).'</p>
                        <p><strong>Color:</strong> '.htmlspecialchars($color).'</p>
                      </div></div></div>';

                echo '<div class="countdown mb-3"><i class="fas fa-clock me-2"></i>
                      Redirigiendo en <span id="cd">5</span> segundos...</div>
                      <script>
                        let t=5, el=document.getElementById("cd");
                        setInterval(()=>{
                          t--; el.textContent=t;
                          if(t<=0) location="./ABM_libro.php";
                        },1000);
                      </script>';
            } else {
                echo '<div class="error-message"><i class="fas fa-exclamation-triangle fs-2 mb-3"></i>
                      <h3>Error al Añadir</h3><p>'.$ins->error.'</p></div>';
            }

            $ins->close();
            $conn->close();
            ?>
        </div>
    </div>

    <!-- Pie de página -->
    <footer class="bg-purple-dark text-white py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h3 class="fs-4 fw-bold">Biblioteca Mágica - Gestión</h3>
                    <p class="text-purple-light mb-0">Jardín de Infantes "Pequeños Exploradores"</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="btn btn-outline-light me-2">Soporte Técnico</a>
                    <a href="#" class="btn btn-outline-light">Manual de Usuario</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
