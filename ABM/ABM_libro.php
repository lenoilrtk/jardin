<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Libros - Biblioteca Mágica</title>
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
        .card-book {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
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
            background-color: rgba(0,0,0,0.6);
        }
    </style>
    <?php include "./conex.php"; ?>
</head>
<body>
    <!-- Encabezado -->
    <header class="header-gradient py-3 shadow">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4 mb-3 mb-md-0 d-flex align-items-center">
                    <div class="bg-white p-2 rounded-circle me-3">
                        <i class="fas fa-book fs-4 text-purple"></i>
                    </div>
                    <h1 class="fs-2 fw-bold text-white mb-0">Gestión de Libros</h1>
                </div>
                <div class="col-md-5 mb-3 mb-md-0">
                    <!-- El buscador ahora está en la sección de filtros -->
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
            <h2 class="display-5 fw-bold text-purple mb-2">Administración de Biblioteca</h2>
            <p class="fs-5 text-purple-dark">Gestiona el catálogo de libros de forma eficiente</p>
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
                    <a href="./ABM_index.php" class="btn btn-outline-secondary rounded-pill me-2">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                    <a href="./ABM_libro_añadir.html" class="btn btn-purple rounded-pill">
                        <i class="fas fa-plus me-2"></i>Añadir Libro
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php
    // -------------------------------
    // Lógica de búsqueda y filtros
    // -------------------------------
    $busqueda = $_GET['buscar'] ?? '';
    $color = $_GET['color'] ?? '';
    $genero = $_GET['genero'] ?? '';

    $condiciones = [];
    if (!empty($busqueda)) {
        $busq = mysqli_real_escape_string($conn, $busqueda);
        $condiciones[] = "titulo LIKE '%$busq%'";
    }
    if (!empty($color)) {
        $col = mysqli_real_escape_string($conn, $color);
        $condiciones[] = "color = '$col'";
    }
    if (!empty($genero)) {
        $gen = mysqli_real_escape_string($conn, $genero);
        $condiciones[] = "clasificacion = '$gen'";
    }
    $condSQL = '';
    if (count($condiciones) > 0) {
        $condSQL = "WHERE " . implode(' AND ', $condiciones);
    }

    // Obtener libros filtrados
    $sql = "SELECT * FROM libros $condSQL ORDER BY id DESC";
    $result = $conn->query($sql);

    // Obtener géneros y colores únicos para los select
    $generosRes = $conn->query("SELECT DISTINCT clasificacion FROM libros WHERE clasificacion <> ''");
    $coloresRes = $conn->query("SELECT DISTINCT color FROM libros WHERE color <> ''");
    ?>

    <!-- Sección de filtros -->
    <div class="container">
        <div class="action-section">
            <form method="GET" action="ABM_libro.php" class="row g-3 align-items-center">
                <div class="col-md-4 position-relative">
                    <i class="fas fa-search position-absolute search-icon text-muted"></i>
                    <input 
                        type="text" 
                        name="buscar" 
                        class="form-control rounded-pill py-2 ps-5" 
                        placeholder="Buscar por título..." 
                        value="<?php echo htmlspecialchars($busqueda); ?>">
                </div>
                <div class="col-md-3">
                    <select name="color" class="form-select rounded-pill">
                        <option value="">Todos los colores</option>
                        <?php while ($fila = $coloresRes->fetch_assoc()): ?>
                            <option value="<?php echo $fila['color']; ?>" <?php echo ($color === $fila['color']) ? 'selected' : ''; ?>>
                                <?php echo $fila['color']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="genero" class="form-select rounded-pill">
                        <option value="">Todos los géneros</option>
                        <?php while ($fila = $generosRes->fetch_assoc()): ?>
                            <option value="<?php echo $fila['clasificacion']; ?>" <?php echo ($genero === $fila['clasificacion']) ? 'selected' : ''; ?>>
                                <?php echo $fila['clasificacion']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-2 text-md-end">
                    <button type="submit" class="btn btn-purple rounded-pill px-4">
                        <i class="fas fa-filter me-2"></i>Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tarjetas de libros -->
    <div class="container-fluid pb-5">
        <div class="row gx-4 gy-4 px-4">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                    $id = $row['id'];
                    $titulo = htmlspecialchars($row['titulo']);
                    $autor = htmlspecialchars($row['autor']);
                    $ilustrador = htmlspecialchars($row['ilustrador']);
                    $editorial = htmlspecialchars($row['editorial']);
                    $clasificacion = htmlspecialchars($row['clasificacion']);
                    $colorPortada = htmlspecialchars($row['color']);
                    $base64img = base64_encode($row['imagen']);
                    ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card card-book h-100">
                            <img 
                                src="data:image/jpeg;base64,<?= $base64img; ?>" 
                                class="card-img-top" 
                                alt="Portada de <?= $titulo; ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-purple mb-2 text-truncate" title="<?= $titulo; ?>">
                                    <?= $titulo; ?>
                                </h5>
                                <p class="card-text mb-1">
                                    <strong>Género:</strong> <?= $clasificacion; ?>
                                </p>
                                <p class="card-text mb-3">
                                    <strong>Color:</strong> <span class="badge bg-secondary"><?= $colorPortada; ?></span>
                                </p>
                                <button 
                                    type="button" 
                                    class="btn btn-outline-primary mt-auto" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalLibro<?= $id; ?>">
                                    Ver detalles
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal para libro <?= $titulo; ?> -->
                    <div 
                        class="modal fade" 
                        id="modalLibro<?= $id; ?>" 
                        tabindex="-1" 
                        aria-labelledby="modalLabel<?= $id; ?>" 
                        aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header bg-purple-dark text-white">
                            <h5 class="modal-title" id="modalLabel<?= $id; ?>">
                                Información de "<?= $titulo; ?>"
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
                                <img 
                                    src="data:image/jpeg;base64,<?= $base64img; ?>" 
                                    class="img-fluid rounded" 
                                    alt="Portada de <?= $titulo; ?>">
                              </div>
                              <div class="col-md-8">
                                <ul class="list-group list-group-flush">
                                  <li class="list-group-item">
                                    <strong>ID:</strong> <?= $id; ?>
                                  </li>
                                  <li class="list-group-item">
                                    <strong>Título:</strong> <?= $titulo; ?>
                                  </li>
                                  <li class="list-group-item">
                                    <strong>Autor:</strong> <?= $autor; ?>
                                  </li>
                                  <li class="list-group-item">
                                    <strong>Ilustrador:</strong> <?= $ilustrador; ?>
                                  </li>
                                  <li class="list-group-item">
                                    <strong>Editorial:</strong> <?= $editorial; ?>
                                  </li>
                                  <li class="list-group-item">
                                    <strong>Género:</strong> <?= $clasificacion; ?>
                                  </li>
                                  <li class="list-group-item">
                                    <strong>Color:</strong> <span class="badge bg-secondary"><?= $colorPortada; ?></span>
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <a 
                                href="./ABM_libro_edit.php?id=<?= $id; ?>" 
                                class="btn btn-outline-primary">
                                <i class="fas fa-edit me-1"></i>Editar
                            </a>
                            <a 
                                href="./ABM_libro_del.php?id=<?= $id; ?>" 
                                class="btn btn-outline-danger" 
                                onclick="return confirm('¿Estás seguro de eliminar este libro?')">
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
                        No se encontraron libros.
                    </div>
                </div>
            <?php endif; ?>
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

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
