<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';
require_once app_path('public/conex.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario - Biblioteca Mágica</title>
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

        .bg-purple-light {
            background-color: #f3e8ff !important;
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

        .search-icon {
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
        }

        .form-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            padding: 40px;
            margin-bottom: 100px;
        }

        .form-section {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            border: 1px solid #e2e8f0;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        .form-label i {
            margin-right: 8px;
            color: #8b5cf6;
        }

        .form-control {
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        }

        .btn-action {
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .section-title {
            color: #8b5cf6;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 12px;
            font-size: 1.2em;
        }

        .preview-container {
            background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            margin-top: 20px;
        }

        .image-preview {
            max-width: 150px;
            max-height: 200px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            margin: 10px auto;
            display: block;
        }

        .book-info-header {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
        }

        .error-message {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
            color: #dc2626;
        }
    </style>
</head>

<body>
    <!-- Encabezado -->
    <header class="header-gradient py-3 shadow">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4 mb-3 mb-md-0 d-flex align-items-center">
                    <div class="bg-white p-2 rounded-circle me-3">
                        <i class="fas fa-edit fs-4 text-purple"></i>
                    </div>
                    <h1 class="fs-2 fw-bold text-white mb-0">Modificar Usuario</h1>
                </div>
                <div class="col-md-5 mb-3 mb-md-0">
                    <div class="position-relative">
                        <i class="fas fa-search position-absolute search-icon text-muted"></i>
                        <input type="text" class="form-control rounded-pill py-2 ps-5" placeholder="Buscar en el catálogo...">
                    </div>
                </div>
                <div class="col-md-3 text-md-end">
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
            <h2 class="display-5 fw-bold text-purple mb-2">Editar Información del Usuario</h2>
            <p class="fs-5 text-purple-dark">Actualiza los datos del usuario</p>
        </div>
    </div>

    <!-- Contenido -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <?php

                if (!isset($_GET['id']) || empty($_GET['id'])) {
                    echo '<div class="error-message">
                            <i class="fas fa-exclamation-triangle fs-2 mb-3"></i>
                            <h3>Error: ID no especificado</h3>
                            <p>No se ha proporcionado un ID válido</p>
                            <a href="' . app_path('public/ABM/Usuarios/ABM_user.php') . '" class="btn btn-purple btn-action">Volver a la Lista</a>
                          </div>';
                    exit;
                }

                $id = intval($_GET['id']);
                $sql = "SELECT * FROM `usuarios` WHERE `usuario_id` LIKE ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                ?>

                    <!-- Información del libro actual -->
                    <div class="book-info-header">
                        <p class="text-muted mb-0">ID Usuario #<?php echo $row["usuario_id"]; ?></p>
                    </div>

                    <div class="form-container">
                        <form action="<?= app_path('public/ABM/Usuarios/Editar/ABM_user_edit_mod.php') ?>?usuario_id=<?php echo $row["usuario_id"]; ?>" method="POST" id="editBookForm">

                            <!-- Información Básica -->
                            <div class="form-section">
                                <h3 class="section-title">
                                    <i class="fas fa-book"></i>
                                    Información
                                </h3>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="titulo" class="form-label">
                                            <i class="fas fa-heading"></i>
                                            ID
                                        </label>
                                        <input type="text" class="form-control" id="usuario_id" name="usuario_id"
                                            value="<?php echo htmlspecialchars($row["usuario_id"]); ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="autor" class="form-label">
                                            <i class="fas fa-user-edit"></i>
                                            Nombre
                                        </label>
                                        <input type="text" class="form-control" id="nombre" name="nombre"
                                            value="<?php echo htmlspecialchars($row["nombre"]); ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="autor" class="form-label">
                                            <i class="fas fa-user-edit"></i>
                                            Apellido
                                        </label>
                                        <input type="text" class="form-control" id="apellido" name="apellido"
                                            value="<?php echo htmlspecialchars($row["apellido"]); ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="autor" class="form-label">
                                            <i class="fas fa-user-edit"></i>
                                            Correo
                                        </label>
                                        <input type="text" class="form-control" id="correo" name="correo"
                                            value="<?php echo htmlspecialchars($row["correo"]); ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="autor" class="form-label">
                                            <i class="fas fa-user-edit"></i>
                                            Documento
                                        </label>
                                        <input type="text" class="form-control" id="documento" name="documento"
                                            value="<?php echo htmlspecialchars($row["documento"]); ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="autor" class="form-label">
                                            <i class="fas fa-user-edit"></i>
                                            Contraseña
                                        </label>
                                        <input type="text" class="form-control" id="contraseña" name="contraseña"
                                            value="<?php echo htmlspecialchars($row["contraseña"]); ?>" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nivel" class="form-label">
                                            <i class="fas fa-palette"></i>
                                            Nivel
                                        </label>
                                        <select class="form-control" id="nivel" name="nivel" required>
                                            <option value="">Selecciona un nivel</option>
                                            <option value="1" <?php echo ($row["nivel"] == "1") ? "selected" : "1"; ?>>🔴 SuperAdmin</option>
                                            <option value="2" <?php echo ($row["nivel"] == "2") ? "selected" : "2"; ?>>🔵 Admin</option>
                                            <option value="3" <?php echo ($row["nivel"] == "3") ? "selected" : "3"; ?>>🟢 Usuario</option>
                                        </select>
                                    </div>

                                </div>




                            </div>

                            <!-- Botones de Acción -->
                            <div class="text-center">
                                <a href="<?= app_path(" public/ABM/Usuarios/ABM_user.php") ?>" class="btn btn-outline-secondary btn-action me-3">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Cancelar
                                </a>
                                <button type="submit" class="btn btn-purple btn-action">
                                    <i class="fas fa-save me-2"></i>
                                    Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>

                <?php
                } else {
                    echo '<div class="error-message">
                            <i class="fas fa-book-dead fs-2 mb-3"></i>
                            <h3>Libro no encontrado</h3>
                            <p>No se encontró ningún libro con el ID especificado.</p>
                            <a href="' . app_path(" public/ABM/Usuarios/ABM_user.php") . '" class="btn btn-purple btn-action">Volver a la Lista</a>
                          </div>';
                }
                $conn->close();
                ?>
            </div>
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

    <script>
        // Validación del formulario
        document.getElementById(' editBookForm').addEventListener('submit', function(e) {
            const requiredFields = ['usuario_id', 'contraseña', 'nivel'];
            let isValid = true;

            requiredFields.forEach(field => {
                const input = document.getElementById(field);
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Por favor, completa todos los campos requeridos.');
                return false;
            }

            // Confirmación antes de guardar
            return confirm('¿Estás seguro de que quieres guardar los cambios en este usuario?');
        });

        // Mostrar vista previa inicial
        window.addEventListener('load', function() {
            previewImage();
        });
    </script>
</body>

</html>