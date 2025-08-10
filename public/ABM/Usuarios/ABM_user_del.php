<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuarios - Biblioteca Mágica</title>
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

        .confirmation-container {
            background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            color: #92400e;
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

        .book-info {
            background: linear-gradient(135deg, #f3e8ff 0%, #e0e7ff 100%);
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
            border: 2px solid #dc2626;
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
    </style>
</head>

<body>
    <!-- Encabezado -->
    <header class="header-gradient py-3 shadow">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 d-flex align-items-center">
                    <div class="bg-white p-2 rounded-circle me-3">
                        <i class="fas fa-trash fs-4 text-purple"></i>
                    </div>
                    <h1 class="fs-2 fw-bold text-white mb-0">Eliminar Usuario</h1>
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
            <h2 class="display-5 fw-bold text-purple mb-2">Gestión de Eliminación</h2>
            <p class="fs-5 text-purple-dark">Procesando solicitud de eliminación de Usuario</p>
        </div>
    </div>

    <!-- Contenido -->
    <div class="container">
        <div class="result-container">
            <?php

            require_once __DIR__ . '/../../../vendor/autoload.php';
            require_once app_path('public/conex.php');

            // Verificar que se haya proporcionado un ID
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                echo '<div class="error-message">
                        <i class="fas fa-exclamation-triangle fs-2 mb-3"></i>
                        <h3>ID No Especificado</h3>
                        <p>No se ha proporcionado un ID.</p>
                      </div>';
                echo '<a href="' . app_path('public/ABM/Usuarios/ABM_user.php') . '" class="btn btn-purple btn-action">Volver a la Lista</a>';
                exit;
            }

            // Validar que el ID sea numérico
            $usuario_id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
            if ($usuario_id === false || $usuario_id <= 0) {
                echo '<div class="error-message">
                        <i class="fas fa-exclamation-triangle fs-2 mb-3"></i>
                        <h3>ID No Válido</h3>
                        <p>El ID proporcionado no es válido.</p>
                      </div>';
                echo '<a href="' . app_path('public/ABM/Usuarios/ABM_user.php') . '" class="btn btn-purple btn-action">Volver a la Lista</a>';
                exit;
            }

            // Verificar conexión
            if ($conn->connect_error) {
                echo '<div class="error-message">
                        <i class="fas fa-database fs-2 mb-3"></i>
                        <h3>Error de Conexión</h3>
                        <p>No se pudo conectar a la base de datos: ' . $conn->connect_error . '</p>
                      </div>';
                echo '<a href="' . app_path('public/ABM/Usuarios/ABM_user.php') . '" class="btn btn-purple btn-action">Intentar de Nuevo</a>';
                exit;
            }

            // Verificar si se ha confirmado la eliminación
            $confirmado = isset($_GET['confirmar']) && $_GET['confirmar'] === 'si';

            if (!$confirmado) {
                // Mostrar información del libro y pedir confirmación
                $sqlInfo = "SELECT * FROM `usuarios` WHERE `usuario_id` LIKE ?";
                $stmtInfo = $conn->prepare($sqlInfo);
                $stmtInfo->bind_param("i", $usuario_id);
                $stmtInfo->execute();
                $resultInfo = $stmtInfo->get_result();

                if ($resultInfo->num_rows === 0) {
                    echo '<div class="error-message">
                            <i class="fas fa-book-dead fs-2 mb-3"></i>
                            <h3>Libro No Encontrado</h3>
                            <p>No se encontró el ID especificado.</p>
                          </div>';
                    echo '<a href="' . app_path('public/ABM/Usuarios/ABM_user.php') . '" class="btn btn-purple btn-action">Volver a la Lista</a>';
                    $stmtInfo->close();
                    $conn->close();
                    exit;
                }

                $row = $resultInfo->fetch_assoc();

                echo '<div class="confirmation-container">
                        <i class="fas fa-exclamation-triangle warning-icon fs-2 mb-3"></i>
                        <h3>⚠️ Confirmación de Eliminación ⚠️</h3>
                        <p class="fs-5 fw-bold">¿Estás seguro de que quieres eliminar este usuario?</p>
                        <p class="mb-0">Esta acción no se puede deshacer.</p>
                      </div>';

                // Mostrar información del libro
                echo '<div class="book-info">
                        <h4 class="text-purple fw-bold mb-3">
                            <i class="fas fa-book me-2"></i>
                            Información del usuario a Eliminar
                        </h4>
                        <div class="row align-items-center">

                            <div class="col-md-8 text-start">
                                <h5 class="fw-bold text-purple">ID: #' . $row['usuario_id'] . ' - ' . htmlspecialchars($row['usuario_id']) . '</h5>
                                <p class="mb-1"><strong>Contraseña:</strong> ' . htmlspecialchars($row['contraseña']) . '</p>
                                <p class="mb-1"><strong>Nivel:</strong> ' . htmlspecialchars($row['nivel']) . '</p>
                            </div>
                        </div>
                      </div>';

                // Botones de confirmación
                echo '<div class="text-center">
                        <a href="./ABM_user.php" class="btn btn-outline-secondary btn-action">
                            <i class="fas fa-times me-2"></i>
                            Cancelar
                        </a>
                        <a href="./ABM_user_del.php?id=' . $usuario_id . '&confirmar=si" class="btn btn-danger btn-action">
                            <i class="fas fa-trash me-2"></i>
                            Confirmar Eliminación
                        </a>
                      </div>';

                $stmtInfo->close();
            } else {
                // Proceder con la eliminación

                // Primero obtener información del libro para mostrar después
                $sqlInfo = "SELECT * FROM `usuarios` WHERE `usuario_id` LIKE ?";
                $stmtInfo = $conn->prepare($sqlInfo);
                $stmtInfo->bind_param("i", $usuario_id);
                $stmtInfo->execute();
                $resultInfo = $stmtInfo->get_result();

                if ($resultInfo->num_rows === 0) {
                    echo '<div class="error-message">
                            <i class="fas fa-book-dead fs-2 mb-3"></i>
                            <h3>Libro No Encontrado</h3>
                            <p>El Usuario que intentas eliminar ya no existe en la base de datos.</p>
                          </div>';
                    echo '<a href="./ABM_user.php" class="btn btn-purple btn-action">Volver a la Lista</a>';
                    $stmtInfo->close();
                    $conn->close();
                    exit;
                }

                $row = $resultInfo->fetch_assoc();
                $stmtInfo->close();

                // Realizar la eliminación con prepared statement
                $sql = "DELETE FROM `usuarios` WHERE `usuarios`.`usuario_id` =  ?";
                $stmt = $conn->prepare($sql);

                if ($stmt === false) {
                    echo '<div class="error-message">
                            <i class="fas fa-exclamation-triangle fs-2 mb-3"></i>
                            <h3>Error en la Consulta</h3>
                            <p>Error al preparar la consulta de eliminación: ' . $conn->error . '</p>
                          </div>';
                    echo '<a href="./ABM_user.php" class="btn btn-purple btn-action">Volver a la Lista</a>';
                    $conn->close();
                    exit;
                }

                $stmt->bind_param("i", $usuario_id);

                if ($stmt->execute()) {
                    if ($stmt->affected_rows > 0) {
                        echo '<div class="success-message">
                                <i class="fas fa-check-circle fs-2 mb-3"></i>
                                <h3>¡Usuario Eliminado Exitosamente!</h3>
                                <p><strong>ID eliminado:</strong> #' . $usuario_id . '</p>
                              </div>';

                        echo '<div class="countdown mb-3">
                                <i class="fas fa-clock me-2"></i>
                                Redirigiendo en <span id="countdown">5</span> segundos...
                              </div>';

                        echo '<a href="./ABM_user.php" class="btn btn-purple btn-action">Ver Lista de Usuarios</a>';

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
                                <i class="fas fa-question-circle fs-2 mb-3"></i>
                                <h3>Libro No Encontrado</h3>
                                <p>No se encontró ningún libro con el ID especificado para eliminar.</p>
                              </div>';
                        echo '<a href="../Libros/ABM_libro.php" class="btn btn-purple btn-action">Volver a la Lista</a>';
                    }
                } else {
                    echo '<div class="error-message">
                            <i class="fas fa-exclamation-triangle fs-2 mb-3"></i>
                            <h3>Error al Eliminar</h3>
                            <p>Se produjo un error al intentar eliminar el libro de la base de datos.</p>
                            <p><strong>Error:</strong> ' . $stmt->error . '</p>
                          </div>';
                    echo '<a href="./ABM_user.php" class="btn btn-purple btn-action">Volver a la Lista</a>';
                    echo '<a href="./ABM_user_del.php?id=' . $usuario_id . '" class="btn btn-outline-danger btn-action">Intentar de Nuevo</a>';
                }

                $stmt->close();
            }

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