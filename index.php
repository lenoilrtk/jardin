<?php
include 'ABM/conex.php';
// Parámetros de búsqueda
$buscar = isset($_GET['buscar']) ? $conn->real_escape_string($_GET['buscar']) : '';
$where  = $buscar ? "AND (titulo LIKE '%$buscar%' OR autor LIKE '%$buscar%')" : '';
// Definir géneros específicos (clasificación)
$generos = ['Cuentos de Hadas','Fábulas con Animales','Poesía Infantil','Libros de Aventuras','Historias de la Naturaleza'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Mágica - Jardín de Infantes</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="styles/index.css">
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
                        <input type="text" name="buscar" class="form-control rounded-pill py-2 ps-5" placeholder="Buscar libros..." value="<?php echo htmlspecialchars($buscar); ?>">
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
    <div class="bg-warning py-4">
        <div class="container text-center">
            <h2 class="display-5 fw-bold text-purple mb-2">¡Bienvenidos a nuestra Biblioteca Mágica!</h2>
            <p class="fs-5 text-purple-dark">Un mundo de aventuras y aprendizaje te espera</p>
        </div>
    </div>

    <!-- Géneros literarios -->
    <div class="container py-5">
        <h2 class="fs-1 fw-bold text-purple mb-4">Géneros Literarios</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <a href="#" class="text-decoration-none">
                    <div class="category-card bg-pink-light rounded-4 p-4 text-center h-100">
                        <div class="icon-wrapper mb-3">
                            <i class="fas fa-book fs-1 text-pink"></i>
                        </div>
                        <h3 class="fs-4 fw-bold mb-2">Cuentos de Hadas</h3>
                        <p class="text-muted">Historias mágicas con princesas, hadas y dragones</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="#" class="text-decoration-none">
                    <div class="category-card bg-green-light rounded-4 p-4 text-center h-100">
                        <div class="icon-wrapper mb-3">
                            <i class="fas fa-book fs-1 text-green"></i>
                        </div>
                        <h3 class="fs-4 fw-bold mb-2">Fábulas con Animales</h3>
                        <p class="text-muted">Relatos con animales que enseñan valores</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="#" class="text-decoration-none">
                    <div class="category-card bg-blue-light rounded-4 p-4 text-center h-100">
                        <div class="icon-wrapper mb-3">
                            <i class="fas fa-book fs-1 text-blue"></i>
                        </div>
                        <h3 class="fs-4 fw-bold mb-2">Poesía Infantil</h3>
                        <p class="text-muted">Versos, rimas y canciones para los más pequeños</p>
                    </div>
                </a>
            </div>
        </div>
        <div class="row g-4 mt-2">
            <div class="col-md-6">
                <a href="#" class="text-decoration-none">
                    <div class="category-card bg-orange-light rounded-4 p-4 text-center h-100">
                        <div class="icon-wrapper mb-3">
                            <i class="fas fa-book fs-1 text-orange"></i>
                        </div>
                        <h3 class="fs-4 fw-bold mb-2">Libros de Aventuras</h3>
                        <p class="text-muted">Historias emocionantes de exploración y descubrimiento</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="#" class="text-decoration-none">
                    <div class="category-card bg-teal-light rounded-4 p-4 text-center h-100">
                        <div class="icon-wrapper mb-3">
                            <i class="fas fa-book fs-1 text-teal"></i>
                        </div>
                        <h3 class="fs-4 fw-bold mb-2">Historias de la Naturaleza</h3>
                        <p class="text-muted">Cuentos sobre plantas, animales y el mundo natural</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Secciones por género dinámicas -->
    <?php foreach ($generos as $cat): ?>
        <?php
        // Verificar si hay libros para esta categoría
        $countRes = $conn->query("SELECT COUNT(*) AS cnt FROM libros WHERE clasificacion='" . $conn->real_escape_string($cat) . "' $where");
        $count    = $countRes->fetch_assoc()['cnt'];
        if ($count > 0):
        ?>
            <div class="container py-4">
                <div class="d-flex align-items-center mb-3">
                    <h2 class="fs-2 fw-bold text-purple mb-0"><?= htmlspecialchars($cat) ?></h2>
                    <i class="fas fa-chevron-right ms-2 text-purple"></i>
                </div>
                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3">
                    <?php
                    $sql = "SELECT titulo, autor, imagen FROM libros WHERE clasificacion='" . $conn->real_escape_string($cat) . "' $where LIMIT 8";
                    $res = $conn->query($sql);
                    while ($lib = $res->fetch_assoc()):
                        $src = !empty($lib['imagen'])
                             ? 'data:image/jpeg;base64,'.base64_encode($lib['imagen'])
                             : 'https://via.placeholder.com/100x140.png?text=Libro';
                    ?>
                        <div class="col">
                            <div class="book-card card h-100 shadow-sm">
                                <div class="book-cover d-flex align-items-center justify-content-center bg-purple" style="height:140px; overflow:hidden;">
                                    <img src="<?= $src ?>" alt="<?= htmlspecialchars($lib['titulo']) ?>" style="max-height:100%; max-width:100%; object-fit:cover;">
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title fw-bold text-truncate"><?= htmlspecialchars($lib['titulo']) ?></h6>
                                    <p class="card-text small text-muted"><?= htmlspecialchars($lib['autor']) ?></p>
                                <//div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

    <!-- Pie de página -->
    <footer class="bg-purple-dark text-white py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <h3 class="fs-4 fw-bold">Biblioteca Mágica</h3>
                    <p class="text-purple-light mb-0">Jardín de Infantes "Pequeños Exploradores"</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="btn btn-outline-light me-2">Contacto</a>
                    <a href="#" class="btn btn-outline-light">Ayuda</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
