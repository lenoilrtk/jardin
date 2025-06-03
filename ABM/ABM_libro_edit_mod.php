<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizando Libro - Biblioteca Mágica</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Estilos personalizados basados en el diseño original */
        .header-gradient {
            background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
        }

        .text-purple {
            color: #8b5cf6 !important;
        }

        .text-purple-dark {
            color: #6d28d9 !important;
        }

        .text-purple-light {
            color: #c4b5fd !important;
        }

        .bg-purple-dark {
            background-color: #6d28d9 !important;
        }

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
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            padding: 40px;
            margin: 50px auto;
            max-width: 700px;
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

        .changes-summary {
            background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%);
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
            text-align: left;
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
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .change-item {
            background: rgba(255, 255, 255, 0.7);
            border-radius: 8px;
            padding: 10px;
            margin: 5px 0;
            border-left: 4px solid #8b5cf6;
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
                        <i class="fas fa-edit fs-4 text-purple"></i>
                    </div>
                    <h1 class="fs-2 fw-bold text-white mb-0">Actualizando Libro</h1>
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
            <h2 class="display-5 fw-bold text-purple mb-2">Resultado de la Actualización</h2>
            <p class="fs-5 text-purple-dark">Procesando los cambios del libro</p>
        </div>
    </div>

    <!-- Contenido -->
    <div class="container">
        <div class="result-container">
            <?php
            include "./conex.php";

            // Procesar imagen si se subió
            $imagen = null;
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $ruta_temporal = $_FILES['imagen']['tmp_name'];
                $imagen = file_get_contents($ruta_temporal);
            } else {
                $imagen = null;
            }
            // Verificar que la petición sea POST
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                echo '<div class="error-message">
                        <i class="fas fa-exclamation-triangle fs-2 mb-3"></i>
                        <h3>Acceso No Válido</h3>
                        <p>Esta página solo puede ser accedida mediante el formulario de edición.</p>
                      </div>';
                echo '<a href="./ABM_libro.php" class="btn btn-purple btn-action">Volver a la Lista</a>';
                exit;
            }

            // Verificar que se haya proporcionado un ID
            if (!isset($_GET['libro_id']) || empty($_GET['libro_id'])) {
                echo '<div class="error-message">
                        <i class="fas fa-exclamation-triangle fs-2 mb-3"></i>
                        <h3>ID No Especificado</h3>
                        <p>No se ha proporcionado un ID válido para actualizar el libro.</p>
                      </div>';
                echo '<a href="./ABM_libro.php" class="btn btn-purple btn-action">Volver a la Lista</a>';
                exit;
            }

            // Función para limpiar y validar datos
            function limpiarDato($dato)
            {
                return htmlspecialchars(strip_tags(trim($dato)));
            }

            // Validar ID
            $libro_id = filter_var($_GET['libro_id'], FILTER_VALIDATE_INT);
            if ($libro_id === false || $libro_id <= 0) {
                echo '<div class="error-message">
                        <i class="fas fa-exclamation-triangle fs-2 mb-3"></i>
                        <h3>ID No Válido</h3>
                        <p>El ID proporcionado no es válido.</p>
                      </div>';
                echo '<a href="./ABM_libro.php" class="btn btn-purple btn-action">Volver a la Lista</a>';
                exit;
            }

            // Recoger y validar datos
            $titulo = limpiarDato($_POST['titulo'] ?? '');
            $autor = limpiarDato($_POST['autor'] ?? '');
            $ilustrador = limpiarDato($_POST['ilustrador'] ?? '');
            $editorial = limpiarDato($_POST['editorial'] ?? '');
            $clasificacion = limpiarDato($_POST['clasificacion'] ?? '');
            $color = limpiarDato($_POST['color'] ?? '');
            $resumen = limpiarDato($_POST['resumen'] ?? '');


            // Validaciones
            $errores = [];

            if (empty($titulo)) $errores[] = "El título es obligatorio";
            if (empty($autor)) $errores[] = "El autor es obligatorio";
            if (empty($ilustrador)) $errores[] = "El ilustrador es obligatorio";
            if (empty($editorial)) $errores[] = "La editorial es obligatoria";
            if (empty($clasificacion)) $errores[] = "La clasificación es obligatoria";
            if (empty($color)) $errores[] = "El color es obligatorio";
            if (empty($resumen)) $errores[] = "El resumen es obligatorio";

            // Si hay errores, mostrarlos
            if (!empty($errores)) {
                echo '<div class="error-message">
                        <i class="fas fa-exclamation-triangle fs-2 mb-3"></i>
                        <h3>Errores en los Datos</h3>
                        <ul class="text-start">';
                foreach ($errores as $error) {
                    echo '<li>' . $error . '</li>';
                }
                echo '</ul></div>';
                echo '<a href="javascript:history.back()" class="btn btn-outline-danger btn-action">Corregir Datos</a>';
                echo '<a href="./ABM_libro.php" class="btn btn-purple btn-action">Ver Lista de Libros</a>';
                exit;
            }

            // Incluir conexión a la base de datos
            include "./conex.php";

            // Verificar conexión
            if ($conn->connect_error) {
                echo '<div class="error-message">
                        <i class="fas fa-database fs-2 mb-3"></i>
                        <h3>Error de Conexión</h3>
                        <p>No se pudo conectar a la base de datos: ' . $conn->connect_error . '</p>
                      </div>';
                echo '<a href="./ABM_libro.php" class="btn btn-purple btn-action">Intentar de Nuevo</a>';
                exit;
            }

            // Obtener datos actuales del libro para comparar cambios
            $sqlActual = "SELECT * FROM libros WHERE id = ?";
            $stmtActual = $conn->prepare($sqlActual);
            $stmtActual->bind_param("i", $libro_id);
            $stmtActual->execute();
            $resultActual = $stmtActual->get_result();

            if ($resultActual->num_rows === 0) {
                echo '<div class="error-message">
                        <i class="fas fa-book-dead fs-2 mb-3"></i>
                        <h3>Libro No Encontrado</h3>
                        <p>No se encontró ningún libro con el ID especificado.</p>
                      </div>';
                echo '<a href="./ABM_libro.php" class="btn btn-purple btn-action">Volver a la Lista</a>';
                $stmtActual->close();
                $conn->close();
                exit;
            }

            $datosActuales = $resultActual->fetch_assoc();
            $stmtActual->close();

            // Verificar si ya existe otro libro con el mismo título y autor (excluyendo el actual)
            $sqlCheck = "SELECT id FROM libros WHERE titulo = ? AND autor = ? AND id != ?";
            $stmtCheck = $conn->prepare($sqlCheck);
            $stmtCheck->bind_param("ssi", $titulo, $autor, $libro_id);
            $stmtCheck->execute();
            $resultCheck = $stmtCheck->get_result();

            if ($resultCheck->num_rows > 0) {
                echo '<div class="error-message">
                        <i class="fas fa-copy fs-2 mb-3"></i>
                        <h3>Libro Duplicado</h3>
                        <p>Ya existe otro libro con el mismo título y autor en la base de datos.</p>
                      </div>';
                echo '<a href="javascript:history.back()" class="btn btn-outline-danger btn-action">Modificar Datos</a>';
                echo '<a href="./ABM_libro.php" class="btn btn-purple btn-action">Ver Lista de Libros</a>';
                $stmtCheck->close();
                $conn->close();
                exit;
            }
            $stmtCheck->close();

            // Preparar la consulta SQL con prepared statement
            $sql = "UPDATE libros SET titulo = ?, autor = ?, ilustrador = ?, editorial = ?, clasificacion = ?, color = ?, observaciones = 'NULL', resumen = ?, origen = 'NULL', imagen = ? WHERE id = ?";

            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                echo '<div class="error-message">
                        <i class="fas fa-exclamation-triangle fs-2 mb-3"></i>
                        <h3>Error en la Consulta</h3>
                        <p>Error al preparar la consulta: ' . $conn->error . '</p>
                      </div>';
                echo '<a href="./ABM_libro.php" class="btn btn-purple btn-action">Intentar de Nuevo</a>';
                $conn->close();
                exit;
            }

            // Vincular parámetros
            $stmt->bind_param("ssssssssi", $titulo, $autor, $ilustrador, $editorial, $clasificacion, $color, $resumen, $imagen, $libro_id);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    echo '<div class="success-message">
                            <i class="fas fa-check-circle fs-2 mb-3"></i>
                            <h3>¡Libro Actualizado Exitosamente!</h3>
                            <p>Los cambios han sido guardados correctamente en el catálogo de la biblioteca.</p>
                          </div>';

                    // Detectar y mostrar cambios realizados
                    $cambios = [];
                    if ($datosActuales['titulo'] != $titulo) $cambios[] = ['campo' => 'Título', 'anterior' => $datosActuales['titulo'], 'nuevo' => $titulo];
                    if ($datosActuales['autor'] != $autor) $cambios[] = ['campo' => 'Autor', 'anterior' => $datosActuales['autor'], 'nuevo' => $autor];
                    if ($datosActuales['ilustrador'] != $ilustrador) $cambios[] = ['campo' => 'Ilustrador', 'anterior' => $datosActuales['ilustrador'], 'nuevo' => $ilustrador];
                    if ($datosActuales['editorial'] != $editorial) $cambios[] = ['campo' => 'Editorial', 'anterior' => $datosActuales['editorial'], 'nuevo' => $editorial];
                    if ($datosActuales['clasificacion'] != $clasificacion) $cambios[] = ['campo' => 'Clasificación', 'anterior' => $datosActuales['clasificacion'], 'nuevo' => $clasificacion];
                    if ($datosActuales['color'] != $color) $cambios[] = ['campo' => 'Color', 'anterior' => $datosActuales['color'], 'nuevo' => $color];
                    if ($datosActuales['resumen'] != $resumen) $cambios[] = ['campo' => 'Resumen', 'anterior' => $datosActuales['resumen'], 'nuevo' => $resumen];
                    if ($datosActuales['imagen'] != $imagen) $cambios[] = ['campo' => 'Imagen', 'anterior' => 'URL anterior', 'nuevo' => 'URL actualizada'];

                    // Registrar cambios en la tabla de movimientos
                    $query = "INSERT INTO `movimientos` (`usuario_id`, `tabla_modif`, `campos_modif`, `valores_modif`, `fecha`) VALUES (?, 'libros', ?, ?, NOW())";
                    $campos_modif = implode(',', array_column($cambios, 'campo'));
                    $valores_modif = implode(',', array_map(function ($c) {
                        return $c['anterior'] . ' -> ' . $c['nuevo'];
                    }, $cambios));
                    $stmtMov = $conn->prepare($query);
                    $usuario_id = $_SESSION['usuario_id']; // Asumimos que el usuario que realiza la acción es el ID 1
                    $stmtMov->bind_param("iss", $usuario_id, $campos_modif, $valores_modif);
                    $stmtMov->execute();
                    $stmtMov->close();

                    if (!empty($cambios)) {
                        echo '<div class="changes-summary">
                                <h4 class="text-purple fw-bold mb-3">
                                    <i class="fas fa-list-alt me-2"></i>
                                    Cambios Realizados
                                </h4>';
                        foreach ($cambios as $cambio) {
                            echo '<div class="change-item">
                                    <strong>' . $cambio['campo'] . ':</strong><br>
                                    <small class="text-muted">Anterior: ' . htmlspecialchars($cambio['anterior']) . '</small><br>
                                    <small class="text-success">Nuevo: ' . htmlspecialchars($cambio['nuevo']) . '</small>
                                  </div>';
                        }
                        echo '</div>';
                    }

                    // Mostrar preview del libro actualizado
                    echo '<div class="book-preview">
                            <h4 class="text-purple fw-bold mb-3">
                                <i class="fas fa-book me-2"></i>
                                Libro Actualizado - ID: #' . $libro_id . '
                            </h4>
                            <div class="row align-items-center">
                                <div class="col-md-4 text-center">
                                    <img src="data:image/jpeg;base64,' . base64_encode($imagen) . '" alt="Portada" 
                                         style="max-width: 120px; max-height: 160px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);"
                                         onerror="this.src=\'/placeholder.svg?height=160&width=120\'">
                                </div>
                                <div class="col-md-8 text-start">
                                    <h5 class="fw-bold text-purple">' . htmlspecialchars($titulo) . '</h5>
                                    <p class="mb-1"><strong>Autor:</strong> ' . htmlspecialchars($autor) . '</p>
                                    <p class="mb-1"><strong>Ilustrador:</strong> ' . htmlspecialchars($ilustrador) . '</p>
                                    <p class="mb-1"><strong>Editorial:</strong> ' . htmlspecialchars($editorial) . '</p>
                                    <p class="mb-1"><strong>Clasificación:</strong> ' . htmlspecialchars($clasificacion) . '</p>
                                    <p class="mb-0"><strong>Color:</strong> ' . htmlspecialchars($color) . '</p>
                                </div>
                            </div>
                          </div>';

                    echo '<div class="countdown mb-3">
                            <i class="fas fa-clock me-2"></i>
                            Redirigiendo en <span id="countdown">5</span> segundos...
                          </div>';

                    echo '<a href="./ABM_libro.php" class="btn btn-purple btn-action">Ver Lista de Libros</a>';
                    echo '<a href="./ABM_libro_edit.php?id=' . $libro_id . '" class="btn btn-outline-primary btn-action">Editar de Nuevo</a>';

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
                            <i class="fas fa-info-circle fs-2 mb-3"></i>
                            <h3>Sin Cambios</h3>
                            <p>No se realizaron cambios en el libro. Los datos son idénticos a los anteriores.</p>
                          </div>';
                    echo '<a href="./ABM_libro.php" class="btn btn-purple btn-action">Ver Lista de Libros</a>';
                    echo '<a href="./ABM_libro_edit.php?id=' . $libro_id . '" class="btn btn-outline-primary btn-action">Editar de Nuevo</a>';
                }
            } else {
                echo '<div class="error-message">
                        <i class="fas fa-exclamation-triangle fs-2 mb-3"></i>
                        <h3>Error al Actualizar el Libro</h3>
                        <p>Se produjo un error al intentar actualizar el libro en la base de datos.</p>
                        <p><strong>Error:</strong> ' . $stmt->error . '</p>
                      </div>';
                echo '<a href="javascript:history.back()" class="btn btn-outline-danger btn-action">Intentar de Nuevo</a>';
                echo '<a href="./ABM_libro.php" class="btn btn-purple btn-action">Ver Lista de Libros</a>';
            }

            // Cerrar statement y conexión
            $stmt->close();
            $conn->close();
            ?>
        </div>
    </div>

    <!-- Pie de página -->
    <footer class="bg-purple-dark text-white py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
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