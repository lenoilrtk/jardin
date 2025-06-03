<?php
// agregarUsuario.php
session_start();
include 'conex.php'; // Ajusta la ruta si tu archivo está en otra carpeta

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recopilar y sanitizar datos
    $nombre    = $conn->real_escape_string(trim($_POST['nombre']));
    $apellido  = $conn->real_escape_string(trim($_POST['apellido']));
    $correo    = $conn->real_escape_string(trim($_POST['correo']));
    $password  = $conn->real_escape_string(trim($_POST['password']));
    $nivel     = (int) $_POST['nivel'];
    $documento = $conn->real_escape_string(trim($_POST['documento']));

    // Validaciones básicas
    if (empty($nombre) || empty($apellido) || empty($correo) || empty($password) || empty($nivel) || empty($documento)) {
        $error = 'Todos los campos son obligatorios.';
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $error = 'El correo ingresado no es válido.';
    } else {
        // Verificar que no exista otro usuario con el mismo correo
        $checkSql  = "SELECT usuario_id FROM usuarios WHERE correo = '$correo' LIMIT 1";
        $checkRes  = $conn->query($checkSql);
        if ($checkRes && $checkRes->num_rows > 0) {
            $error = 'Ya existe un usuario registrado con ese correo.';
        } else {
            // Insertar nuevo usuario
            $insertSql = "
                INSERT INTO usuarios (nombre, apellido, correo, contraseña, nivel, documento)
                VALUES ('$nombre', '$apellido', '$correo', '$password', $nivel, '$documento')
            ";
            if ($conn->query($insertSql)) {
                $success = 'Usuario agregado correctamente.';
                // Redirigir de vuelta al listado tras 2 segundos
                header("refresh:2; url=ABM_user.php");
            } else {
                $error = 'Error al insertar el usuario: ' . $conn->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Usuario - ABM</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ==============================
           PALETA DE COLORES PERSONALIZADA
           ============================== */
        .header-gradient {
            background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
        }
        .text-purple {
            color: #8b5cf6 !important;
        }
        .text-purple-dark {
            color: #6d28d9 !important;
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
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .form-card {
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header-gradient py-3 mb-4 shadow-sm">
        <div class="container d-flex align-items-center">
            <i class="fas fa-users fa-2x me-2 text-white"></i>
            <h1 class="h3 text-white mb-0">Añadir Nuevo Usuario</h1>
            <div class="ms-auto">
                <a href="ABM_user.php" class="btn btn-outline-light">
                    <i class="fas fa-arrow-left me-1"></i>Volver al Listado
                </a>
            </div>
        </div>
    </header>

    <div class="container">
        <?php if ($error): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($success): ?>
            <div class="alert alert-success text-center"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <div class="card form-card mb-5">
            <div class="card-body p-4">
                <form method="POST" action="agregarUsuario.php">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label fw-medium">Nombre</label>
                            <input
                                type="text"
                                id="nombre"
                                name="nombre"
                                class="form-control"
                                placeholder="Juan"
                                value="<?= isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '' ?>"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="apellido" class="form-label fw-medium">Apellido</label>
                            <input
                                type="text"
                                id="apellido"
                                name="apellido"
                                class="form-control"
                                placeholder="Pérez"
                                value="<?= isset($_POST['apellido']) ? htmlspecialchars($_POST['apellido']) : '' ?>"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="correo" class="form-label fw-medium">Correo Electrónico</label>
                            <input
                                type="email"
                                id="correo"
                                name="correo"
                                class="form-control"
                                placeholder="ejemplo@dominio.com"
                                value="<?= isset($_POST['correo']) ? htmlspecialchars($_POST['correo']) : '' ?>"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-medium">Contraseña</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control"
                                placeholder="********"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="documento" class="form-label fw-medium">Documento (DNI)</label>
                            <input
                                type="text"
                                id="documento"
                                name="documento"
                                class="form-control"
                                placeholder="12345678"
                                value="<?= isset($_POST['documento']) ? htmlspecialchars($_POST['documento']) : '' ?>"
                                pattern="[0-9]{6,10}"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="nivel" class="form-label fw-medium">Nivel de Usuario</label>
                            <select id="nivel" name="nivel" class="form-select" required>
                                <option value="">Selecciona un nivel</option>
                                <option value="1" <?= (isset($_POST['nivel']) && $_POST['nivel']=='1') ? 'selected' : '' ?>>1 - Básico</option>
                                <option value="2" <?= (isset($_POST['nivel']) && $_POST['nivel']=='2') ? 'selected' : '' ?>>2 - Encargado</option>
                                <option value="3" <?= (isset($_POST['nivel']) && $_POST['nivel']=='3') ? 'selected' : '' ?>>3 - Administrador</option>
                            </select>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-purple px-4 py-2 rounded-pill">
                            <i class="fas fa-plus me-1"></i>Crear Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
