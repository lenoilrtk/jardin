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
                    <h1 class="fs-2 fw-bold text-white mb-0">Actualizando usuario</h1>
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
            <p class="fs-5 text-purple-dark">Procesando los cambios del usuario</p>
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
                        <p>Esta página solo puede ser accedida mediante el formulario de edición.</p>
                      </div>';
                echo '<a href="./ABM_libro.php" class="btn btn-purple btn-action">Volver a la Lista</a>';
                exit;
            }

            // Verificar que se haya proporcionado un ID
            if (!isset($_GET['usuario_id']) || empty($_GET['usuario_id'])) {
                echo '<div class="error-message">
                        <i class="fas fa-exclamation-triangle fs-2 mb-3"></i>
                        <h3>ID No Especificado</h3>
                        <p>No se ha proporcionado un ID válido</p>
                      </div>';
                echo '<a href="./ABM_libro.php" class="btn btn-purple btn-action">Volver a la Lista</a>';
                exit;
            }

            // Función para limpiar y validar datos
            function limpiarDato($dato)
            {
                return htmlspecialchars(strip_tags(trim($dato)));
            }

            // Función para validar URL de imagen
            function validarURL($url)
            {
                return filter_var($url, FILTER_VALIDATE_URL) !== false;
            }

            // Validar ID
            $usuario_id = filter_var($_GET['usuario_id'], FILTER_VALIDATE_INT);
            if ($usuario_id === false || $usuario_id <= 0) {
                echo '<div class="error-message">
                        <i class="fas fa-exclamation-triangle fs-2 mb-3"></i>
                        <h3>ID No Válido</h3>
                        <p>El ID proporcionado no es válido.</p>
                      </div>';
                echo '<a href="./ABM_user.php" class="btn btn-purple btn-action">Volver a la Lista</a>';
                exit;
            }

            // Recoger y validar datos
            $usuario_id = limpiarDato($_POST['usuario_id'] ?? '');
            $contraseña = limpiarDato($_POST['contraseña'] ?? '');
            $nivel = limpiarDato($_POST['nivel'] ?? '');


            // Validaciones
            $errores = [];

            if (empty($usuario_id)) $errores[] = "El ID del usuario es obligatorio";
            if (empty($contraseña)) $errores[] = "La contraseña es obligatoria";
            if (empty($nivel)) $errores[] = "El nivel de acceso es obligatorio";

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
                echo '<a href="./ABM_user.php" class="btn btn-purple btn-action">Ver Lista de Libros</a>';
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
                echo '<a href="./ABM_user.php" class="btn btn-purple btn-action">Intentar de Nuevo</a>';
                exit;
            }

            // Obtener datos actuales del libro para comparar cambios
            $sqlActual = "SELECT * FROM `usuarios` WHERE `usuario_id` LIKE ?";
            $stmtActual = $conn->prepare($sqlActual);
            $stmtActual->bind_param("i", $usuario_id);
            $stmtActual->execute();
            $resultActual = $stmtActual->get_result();

            if ($resultActual->num_rows === 0) {
                echo '<div class="error-message">
                        <i class="fas fa-book-dead fs-2 mb-3"></i>
                        <h3>Libro No Encontrado</h3>
                        <p>No se encontró el ID especificado.</p>
                      </div>';
                echo '<a href="./ABM_user.php" class="btn btn-purple btn-action">Volver a la Lista</a>';
                $stmtActual->close();
                $conn->close();
                exit;
            }

            $datosActuales = $resultActual->fetch_assoc();
            $stmtActual->close();

            // Preparar la consulta SQL con prepared statement

            $sql =  "UPDATE `usuarios` SET `usuario_id` = ?, `contraseña` = ?, `nivel` = ? WHERE `usuarios`.`usuario_id` = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                echo '<div class="error-message">
                    <i class="fas fa-exclamation-triangle fs-2 mb-3"></i>
                    <h3>Error en la Consulta</h3>
                    <p>Error al preparar la consulta: ' . $conn->error . '</p>
                  </div>';
                echo '<a href="./ABM_user.php" class="btn btn-purple btn-action">Intentar de Nuevo</a>';
                $conn->close();
                exit;
            }
            // Vincular parámetros
            $stmt->bind_param("sssi", $usuario_id, $contraseña, $nivel, $datosActuales['usuario_id']);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    echo '<div class="success-message">
                            <i class="fas fa-check-circle fs-2 mb-3"></i>
                            <h3>Actualizado Exitosamente!</h3>
                            <p>Los cambios han sido guardados correctamente en el catálogo de la biblioteca.</p>
                          </div>';

                    // Detectar y mostrar cambios realizados
                    $cambios = [];
                    if ($datosActuales['usuario_id'] !== $usuario_id) $cambios[] = ['campo' => 'usuario_id', 'anterior' => $datosActuales['usuario_id'], 'nuevo' => $usuario_id];
                    if ($datosActuales['contraseña'] !== $contraseña) $cambios[] = ['campo' => 'contraseña', 'anterior' => $datosActuales['contraseña'], 'nuevo' => $contraseña];
                    if ($datosActuales['nivel'] !== $nivel) $cambios[] = ['campo' => 'nivel', 'anterior' => $datosActuales['nivel'], 'nuevo' => $nivel];
                    $query = "INSERT INTO `movimientos` (`usuario_id`, `tabla_modif`, `campos_modif`, `valores_modif`, `fecha`) VALUES (?, 'usuarios', ?, ?, NOW())";
                    $campos_modif = implode(',', array_column($cambios, 'campo'));
                    $valores_modif = implode(',', array_map(function ($c) {
                        return $c['anterior'] . ' -> ' . $c['nuevo'];
                    }, $cambios));
                    $stmtMov = $conn->prepare($query);
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
                                Usuario Actualizado - ID: #' . $usuario_id . '
                            </h4>
                            <div class="row align-items-center">
                                <div class="col-md-8 text-start">
                                    <h5 class="fw-bold text-purple">' . htmlspecialchars($usuario_id) . '</h5>
                                    <p class="mb-1"><strong>Contraseña:</strong> ' . htmlspecialchars($contraseña) . '</p>
                                    <p class="mb-1"><strong>Nivel:</strong> ' . htmlspecialchars($nivel) . '</p>
                                </div>
                            </div>
                          </div>';

                    echo '<div class="countdown mb-3">
                            <i class="fas fa-clock me-2"></i>
                            Redirigiendo en <span id="countdown">5</span> segundos...
                          </div>';

                    echo '<a href="./ABM_user.php" class="btn btn-purple btn-action">Ver Lista de Usuarios</a>';
                    echo '<a href="./ABM_user_edit.php?id=' . $usuario_id . '" class="btn btn-outline-primary btn-action">Editar de Nuevo</a>';

                    // JavaScript para redirección automática
                    echo '<script>
                            let timeLeft = 5;
                            const countdownElement = document.getElementById("countdown");
                            
                            const timer = setInterval(function() {
                                timeLeft--;
                                countdownElement.textContent = timeLeft;
                                
                                if (timeLeft <= 0) {
                                    clearInterval(timer);
                                    window.location.href = "./ABM_user.php";
                                }
                            }, 1000);
                          </script>';
                } else {
                    echo '<div class="error-message">
                            <i class="fas fa-info-circle fs-2 mb-3"></i>
                            <h3>Sin Cambios</h3>
                            <p>No se realizaron cambios. Los datos son idénticos a los anteriores.</p>
                          </div>';
                    echo '<a href="./ABM_user.php" class="btn btn-purple btn-action">Ver Usuarios</a>';
                    echo '<a href="./ABM_user_edit.php?id=' . $usuario_id . '" class="btn btn-outline-primary btn-action">Editar de Nuevo</a>';
                }
            } else {
                echo '<div class="error-message">
                        <i class="fas fa-exclamation-triangle fs-2 mb-3"></i>
                        <h3>Error al Actualizar</h3>
                        <p>Se produjo un error al intentar actualizar.</p>
                        <p><strong>Error:</strong> ' . $stmt->error . '</p>
                      </div>';
                echo '<a href="javascript:history.back()" class="btn btn-outline-danger btn-action">Intentar de Nuevo</a>';
                echo '<a href="./ABM_user.php" class="btn btn-purple btn-action">Ver Lista de Libros</a>';
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