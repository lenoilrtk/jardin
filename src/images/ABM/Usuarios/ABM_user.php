<?php
session_start();
include './conex.php';

// ----- Procesar parámetros de búsqueda y filtro -----
$buscar      = $_GET['buscar'] ?? '';
$nivelFiltro = $_GET['nivel'] ?? '';

// Construir condiciones dinámicas
$condiciones = [];
if (!empty($buscar)) {
    $b = $conn->real_escape_string($buscar);
    // Buscar por nombre, apellido, correo o documento
    $condiciones[] = "(nombre LIKE '%$b%' OR apellido LIKE '%$b%' OR correo LIKE '%$b%' OR documento LIKE '%$b%')";
}
if (!empty($nivelFiltro)) {
    $n = (int)$nivelFiltro;
    $condiciones[] = "nivel = $n";
}

$condSQL = '';
if (count($condiciones) > 0) {
    $condSQL = 'WHERE ' . implode(' AND ', $condiciones);
}

// Obtener usuarios según búsqueda/filtro
$sql    = "SELECT * FROM usuarios $condSQL ORDER BY usuario_id DESC";
$result = $conn->query($sql);

// Para el select de niveles (roles)
$niveles = [
    1 => 'Usuario',
    2 => 'Bibliotecario',
    3 => 'Directivo'
];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
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

        .card-book {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .card-book:hover {
            transform: translateY(-5px);
        }

        .card-img-top {
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            object-fit: cover;
            height: 200px;
        }

        .action-section {
            background: linear-gradient(135deg, #f3e8ff 0%, #e0e7ff 100%);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .modal-backdrop-custom {
            background-color: rgba(0, 0, 0, 0.6);
        }

        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
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
                        <i class="fas fa-users fs-4 text-purple"></i>
                    </div>
                    <h1 class="fs-2 fw-bold text-white mb-0">Gestión de Usuarios</h1>
                </div>
                <div class="col-md-5 mb-3 mb-md-0">
                    <!-- El buscador está en la sección de filtros -->
                </div>
                <div class="col-md-3 text-md-end">
                    <span class="text-white fw-bold">
                        <i class="fas fa-user-circle me-2"></i>¡Hola, Administrador!
                    </span>
                </div>
            </div>
        </div>
    </header>

    <!-- Banner principal (amarillo) -->
    <div class="py-4" style="background-color: #fbbf24;">
        <div class="container text-center">
            <h2 class="display-5 fw-bold text-purple mb-2">Administración de Usuarios</h2>
            <p class="fs-5 text-purple-dark">Gestiona los usuarios de forma eficiente</p>
        </div>
    </div>

    <!-- Botones de acción -->
    <div class="container py-4">
        <div class="action-buttons">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <h3 class="fs-4 fw-bold text-purple mb-0">
                        <i class="fas fa-tools me-2"></i>Acciones Rápidas
                    </h3>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="../ABM_index.php" class="btn btn-outline-secondary rounded-pill me-2">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                    <a href="./Añadir/agregarUsuario.php" class="btn btn-purple rounded-pill">
                        <i class="fas fa-plus me-2"></i>Añadir Usuario
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de filtros -->
    <div class="container">
        <div class="action-section">
            <form method="GET" action="ABM_user.php" class="row g-3 align-items-center">
                <div class="col-md-5 position-relative">
                    <i class="fas fa-search position-absolute search-icon text-muted"></i>
                    <input
                        type="text"
                        name="buscar"
                        class="form-control rounded-pill py-2 ps-5"
                        placeholder="Buscar por nombre, apellido, correo o documento..."
                        value="<?php echo htmlspecialchars($buscar); ?>">
                </div>
                <div class="col-md-4">
                    <select name="nivel" class="form-select rounded-pill">
                        <option value="">Todos los niveles</option>
                        <?php foreach ($niveles as $key => $label): ?>
                            <option value="<?php echo $key; ?>" <?php echo ($nivelFiltro == $key) ? 'selected' : ''; ?>>
                                <?php echo $label; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3 text-md-end">
                    <button type="submit" class="btn btn-purple rounded-pill px-4">
                        <i class="fas fa-filter me-2"></i>Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tarjetas de usuarios -->
    <div class="container-fluid pb-5">
        <div class="row gx-4 gy-4 px-4">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($user = $result->fetch_assoc()):
                    $uid       = $user['usuario_id'];
                    $nombre    = htmlspecialchars($user['nombre']);
                    $apellido  = htmlspecialchars($user['apellido']);
                    $correo    = htmlspecialchars($user['correo']);
                    $nivelVal  = (int)$user['nivel'];
                    $documento = htmlspecialchars($user['documento']);

                    $nivelText = $niveles[$nivelVal] ?? 'Desconocido';
                    switch ($nivelVal) {
                        case 1:
                            $nivelBadge = 'badge bg-green text-dark';
                            break;
                        case 2:
                            $nivelBadge = 'badge bg-blue text-dark';
                            break;
                        case 3:
                            $nivelBadge = 'badge bg-orange text-dark';
                            break;
                        default:
                            $nivelBadge = 'badge bg-secondary text-dark';
                            break;
                    }
                ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card card-book h-100">
                            <div class="card-body d-flex flex-column">
                                <div class="text-center mb-3">
                                    <i class="fas fa-user-circle fa-6x text-purple-light"></i>
                                </div>
                                <h5 class="card-title text-purple mb-1 text-center">
                                    <?php echo $nombre . ' ' . $apellido; ?>
                                </h5>
                                <p class="card-text text-muted mb-2 text-center"><?php echo $correo; ?></p>
                                <div class="text-center mb-3">
                                    <span class="<?php echo $nivelBadge; ?>"><?php echo $nivelText; ?></span>
                                </div>
                                <button
                                    type="button"
                                    class="btn btn-outline-primary mt-auto"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalUser<?php echo $uid; ?>">
                                    Ver detalles
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal para usuario <?php echo $nombre . ' ' . $apellido; ?> -->
                    <div
                        class="modal fade"
                        id="modalUser<?php echo $uid; ?>"
                        tabindex="-1"
                        aria-labelledby="modalLabel<?php echo $uid; ?>"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-purple-dark text-white">
                                    <h5 class="modal-title" id="modalLabel<?php echo $uid; ?>">
                                        Información de "<?php echo $nombre . ' ' . $apellido; ?>"
                                    </h5>
                                    <button
                                        type="button"
                                        class="btn-close btn-close-white"
                                        data-bs-dismiss="modal"
                                        aria-label="Cerrar">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4 text-center mb-3 mb-md-0">
                                            <i class="fas fa-user-circle fa-7x text-purple-light"></i>
                                        </div>
                                        <div class="col-md-8">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <strong>ID:</strong> <?php echo $uid; ?>
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>Nombre:</strong> <?php echo $nombre; ?>
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>Apellido:</strong> <?php echo $apellido; ?>
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>Correo:</strong> <?php echo $correo; ?>
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>Documento:</strong> <?php echo $documento; ?>
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>Nivel:</strong> <span class="<?php echo $nivelBadge; ?>"><?php echo $nivelText; ?></span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a
                                        href="./Editar/ABM_user_edit.php?id=<?php echo $uid; ?>"
                                        class="btn btn-outline-primary">
                                        <i class="fas fa-edit me-1"></i>Editar
                                    </a>
                                    <a
                                        href="./ABM_user_del.php?id=<?php echo $uid; ?>"
                                        class="btn btn-outline-danger"
                                        onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                                        <i class="fas fa-trash me-1"></i>Borrar
                                    </a>
                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                        data-bs-dismiss="modal">
                                        Cerrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-secondary text-center" role="alert">
                        No se encontraron usuarios.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <footer class="bg-purple-dark text-white py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <h3 class="fs-4 fw-bold">Sistema de Usuarios - Gestión</h3>
                    <p class="text-purple-light mb-0">Administración interna de la plataforma</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="btn btn-outline-light me-2">Soporte Técnico</a>
                    <a href="#" class="btn btn-outline-light">Manual de Usuario</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>