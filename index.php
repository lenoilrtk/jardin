<?php
include 'ABM/conex.php';

// Parámetros de búsqueda y género
$buscar = isset($_GET['buscar']) ? $conn->real_escape_string($_GET['buscar']) : '';
$generoSeleccionado = isset($_GET['genero']) ? $conn->real_escape_string($_GET['genero']) : '';

// Condición WHERE para búsqueda
$whereBuscar = $buscar
    ? "AND (titulo LIKE '%$buscar%' OR autor LIKE '%$buscar%')"
    : '';
// Lista de géneros disponibles
$generos = [
    'Cuentos de Hadas',
    'Fábulas con Animales',
    'Poesía Infantil',
    'Libros de Aventuras',
    'Historias de la Naturaleza'
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Mágica - Jardín de Infantes</title>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    >

    <!-- Estilos inline para colores más vivos -->
    <style>
        /* Encabezado: degradado más vivo (rosado coral) */
        .header-gradient {
            background: linear-gradient(90deg,rgb(226, 154, 255) 0%, #ff7b89 100%);
        }
        .text-purple {
            color: #b23a48 !important; /* Un rosado más intenso */
        }
        .bg-purple {
            background-color: #ff7b89 !important;
        }

        /* Banner principal: fondo amarillo más vivo */
        .bg-vivid-yellow {
            background-color:rgb(255, 214, 50) !important;
        }
        .text-purple-dark {
            color: #4b2c3d !important; /* Texto oscuro que contraste */
        }

        /* Tarjetas de categoría con colores más saturados */
        .bg-pink-light {
            background-color: #ffccd5 !important;
        }
        .text-pink {
            color: #e63946 !important;
        }
        .bg-green-light {
            background-color: #b7e4c7 !important;
        }
        .text-green {
            color: #2d6a4f !important;
        }
        .bg-blue-light {
            background-color: #aedff7 !important;
        }
        .text-blue {
            color: #1d3557 !important;
        }
        .bg-orange-light {
            background-color: #ffd6a5 !important;
        }
        .text-orange {
            color: #e76f51 !important;
        }
        .bg-teal-light {
            background-color: #a5f3fc !important;
        }
        .text-teal {
            color: #0a9396 !important;
        }

        /* Tarjetas de libro: fondo violeta más vivo para portada */
        .book-cover.bg-purple {
            background-color: #ff7b89 !important;
        }
        .search-icon {
    /* Centra verticalmente la lupa dentro del input */
    top: 50% !important;
    left: 1rem;               /* Ajusta este valor si cambias el padding-left del input */
    transform: translateY(-50%);
}
    </style>
</head>
<body>
    <!-- Encabezado -->
    <header class="header-gradient py-3 shadow">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4 d-flex align-items-center">
                    <div class="bg-white p-2 rounded-circle me-3">
                        <i class="fas fa-book fs-4 text-purple"></i>
                    </div>
                    <h1 class="fs-2 fw-bold text-white mb-0">Biblioteca Mágica</h1>
                </div>
                <div class="col-md-5">
                    <form action="index.php" method="GET" class="position-relative">
    <i class="fas fa-search position-absolute search-icon text-muted"></i>
    <input
        type="text"
        name="buscar"
        class="form-control rounded-pill py-2 ps-5"
        placeholder="Buscar libros..."
        value="<?php echo htmlspecialchars($buscar); ?>"
    >
</form>

                </div>
                <div class="col-md-3 text-md-end">
                    <a href="login.php" class="btn btn-light rounded-pill px-4">
                        <i class="fas fa-user me-2"></i>Iniciar Sesión
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Banner principal -->
    <div class="bg-vivid-yellow py-4">
        <div class="container text-center">
            <h2 class="display-5 fw-bold text-purple mb-2">
                ¡Bienvenidos a nuestra Biblioteca Mágica!
            </h2>
            <p class="fs-5 text-purple-dark">
                Un mundo de aventuras y aprendizaje te espera
            </p>
        </div>
    </div>

    <!-- Resultados generales de búsqueda -->
    <?php if ($buscar && !$generoSeleccionado): ?>
        <div class="container py-4">
            <h2 class="fs-2 fw-bold text-purple mb-3">
                Resultados de búsqueda para "<?= htmlspecialchars($buscar) ?>"
            </h2>
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3">
                <?php
                $sqlBusqueda = "
                    SELECT titulo, autor, imagen
                    FROM libros
                    WHERE (titulo LIKE '%$buscar%' OR autor LIKE '%$buscar%')
                ";
                $resBusqueda = $conn->query($sqlBusqueda);
                if ($resBusqueda->num_rows > 0):
                    while ($lib = $resBusqueda->fetch_assoc()):
                        $src = !empty($lib['imagen'])
                            ? 'data:image/jpeg;base64,' . base64_encode($lib['imagen'])
                            : 'https://via.placeholder.com/100x140.png?text=Libro';
                ?>
                    <div class="col">
                        <div class="book-card card h-100 shadow-sm">
                            <div
                                class="book-cover d-flex align-items-center justify-content-center bg-purple"
                                style="height:140px; overflow:hidden;"
                            >
                                <img
                                    src="<?= $src ?>"
                                    alt="<?= htmlspecialchars($lib['titulo']) ?>"
                                    style="max-height:100%; max-width:100%; object-fit:cover;"
                                >
                            </div>
                            <div class="card-body">
                                <h6 class="card-title fw-bold text-truncate">
                                    <?= htmlspecialchars($lib['titulo']) ?>
                                </h6>
                                <p class="card-text small text-muted">
                                    <?= htmlspecialchars($lib['autor']) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php
                    endwhile;
                else:
                ?>
                    <p class="text-muted">
                        No se encontraron libros que coincidan con tu búsqueda.
                    </p>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Géneros literarios: siempre se muestran para seleccionar -->
    <div class="container py-5">
        <h2 class="fs-1 fw-bold text-purple mb-4">Géneros Literarios</h2>
        <div class="row g-4">
            <?php foreach ($generos as $cat): ?>
                <div class="col-md-4">
                    <a href="?genero=<?= urlencode($cat) ?>" class="text-decoration-none">
                        <?php
                        // Definir clase de fondo e ícono según género
                        switch ($cat) {
                            case 'Cuentos de Hadas':
                                $bgClass = 'bg-pink-light';
                                $iconColor = 'text-pink';
                                break;
                            case 'Fábulas con Animales':
                                $bgClass = 'bg-green-light';
                                $iconColor = 'text-green';
                                break;
                            case 'Poesía Infantil':
                                $bgClass = 'bg-blue-light';
                                $iconColor = 'text-blue';
                                break;
                            case 'Libros de Aventuras':
                                $bgClass = 'bg-orange-light';
                                $iconColor = 'text-orange';
                                break;
                            case 'Historias de la Naturaleza':
                                $bgClass = 'bg-teal-light';
                                $iconColor = 'text-teal';
                                break;
                            default:
                                $bgClass = 'bg-light';
                                $iconColor = 'text-muted';
                        }
                        ?>
                        <div class="category-card <?= $bgClass ?> rounded-4 p-4 text-center h-100">
                            <div class="icon-wrapper mb-3">
                                <i class="fas fa-book fs-1 <?= $iconColor ?>"></i>
                            </div>
                            <h3 class="fs-4 fw-bold mb-2"><?= htmlspecialchars($cat) ?></h3>
                            <p class="text-muted">
                                <?php
                                // Descripción breve según género
                                switch ($cat) {
                                    case 'Cuentos de Hadas':
                                        echo 'Historias mágicas con princesas, hadas y dragones';
                                        break;
                                    case 'Fábulas con Animales':
                                        echo 'Relatos con animales que enseñan valores';
                                        break;
                                    case 'Poesía Infantil':
                                        echo 'Versos, rimas y canciones para los más pequeños';
                                        break;
                                    case 'Libros de Aventuras':
                                        echo 'Historias emocionantes de exploración y descubrimiento';
                                        break;
                                    case 'Historias de la Naturaleza':
                                        echo 'Cuentos sobre plantas, animales y el mundo natural';
                                        break;
                                }
                                ?>
                            </p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Si se seleccionó un género, mostrar solo ese género -->
    <?php if ($generoSeleccionado): ?>
        <div class="container py-4">
            <div class="d-flex align-items-center mb-3">
                <h2 class="fs-2 fw-bold text-purple mb-0">
                    <?= htmlspecialchars($generoSeleccionado) ?>
                </h2>
                <i class="fas fa-chevron-right ms-2 text-purple"></i>
            </div>
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3">
                <?php
                $sqlGenero = "
                    SELECT titulo, autor, imagen
                    FROM libros
                    WHERE clasificacion='$generoSeleccionado'
                    $whereBuscar
                ";
                $resGenero = $conn->query($sqlGenero);
                if ($resGenero->num_rows > 0):
                    while ($lib = $resGenero->fetch_assoc()):
                        $src = !empty($lib['imagen'])
                            ? 'data:image/jpeg;base64,' . base64_encode($lib['imagen'])
                            : 'https://via.placeholder.com/100x140.png?text=Libro';
                ?>
                    <div class="col">
                        <div class="book-card card h-100 shadow-sm">
                            <div
                                class="book-cover d-flex align-items-center justify-content-center bg-purple"
                                style="height:140px; overflow:hidden;"
                            >
                                <img
                                    src="<?= $src ?>"
                                    alt="<?= htmlspecialchars($lib['titulo']) ?>"
                                    style="max-height:100%; max-width:100%; object-fit:cover;"
                                >
                            </div>
                            <div class="card-body">
                                <h6 class="card-title fw-bold text-truncate">
                                    <?= htmlspecialchars($lib['titulo']) ?>
                                </h6>
                                <p class="card-text small text-muted">
                                    <?= htmlspecialchars($lib['autor']) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php
                    endwhile;
                else:
                ?>
                    <p class="text-muted">
                        No se encontraron libros en este género.
                    </p>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <!-- Si no hay género seleccionado, mostrar secciones de cada género -->
        <?php foreach ($generos as $cat): ?>
            <?php
            // Contar libros en este género (y búsqueda, si aplica)
            $countRes = $conn->query("
                SELECT COUNT(*) AS cnt
                FROM libros
                WHERE clasificacion='" . $conn->real_escape_string($cat) . "'
                $whereBuscar
            ");
            $count = $countRes->fetch_assoc()['cnt'];
            if ($count > 0):
            ?>
                <div class="container py-4">
                    <div class="d-flex align-items-center mb-3">
                        <h2 class="fs-2 fw-bold text-purple mb-0">
                            <?= htmlspecialchars($cat) ?>
                        </h2>
                        <i class="fas fa-chevron-right ms-2 text-purple"></i>
                    </div>
                    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3">
                        <?php
                        $sql = "
                            SELECT titulo, autor, imagen
                            FROM libros
                            WHERE clasificacion='" . $conn->real_escape_string($cat) . "'
                            $whereBuscar
                        ";
                        $res = $conn->query($sql);
                        while ($lib = $res->fetch_assoc()):
                            $src = !empty($lib['imagen'])
                                ? 'data:image/jpeg;base64,' . base64_encode($lib['imagen'])
                                : 'https://via.placeholder.com/100x140.png?text=Libro';
                        ?>
                            <div class="col">
                                <div class="book-card card h-100 shadow-sm">
                                    <div
                                        class="book-cover d-flex align-items-center justify-content-center bg-purple"
                                        style="height:140px; overflow:hidden;"
                                    >
                                        <img
                                            src="<?= $src ?>"
                                            alt="<?= htmlspecialchars($lib['titulo']) ?>"
                                            style="max-height:100%; max-width:100%; object-fit:cover;"
                                        >
                                    </div>
                                    <div class="card-body">
                                        <h6 class="card-title fw-bold text-truncate">
                                            <?= htmlspecialchars($lib['titulo']) ?>
                                        </h6>
                                        <p class="card-text small text-muted">
                                            <?= htmlspecialchars($lib['autor']) ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Pie de página -->
    <footer class="bg-purple-dark text-white py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <h3 class="fs-4 fw-bold">Biblioteca Mágica</h3>
                    <p class="text-purple-light mb-0">
                        Jardín de Infantes "Pequeños Exploradores"
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="btn btn-outline-light me-2">Contacto</a>
                    <a href="#" class="btn btn-outline-light">Ayuda</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    ></script>
</body>
</html>
