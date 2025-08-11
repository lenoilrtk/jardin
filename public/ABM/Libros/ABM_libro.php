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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e0f2fe 0%, #e0f7fa 50%, #e8f5e8 100%);
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* Header Styles */
        .admin-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid #b2dfdb;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 0;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .admin-logo {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo-icon {
            background: linear-gradient(135deg, #26a69a, #00acc1);
            padding: 1rem;
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .logo-icon i {
            color: white;
            font-size: 1.5rem;
        }

        .logo-text h1 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #00695c;
            margin-bottom: 0.25rem;
        }

        .logo-text p {
            font-size: 0.875rem;
            color: #26a69a;
            margin: 0;
        }

        .user-info {
            color: #26a69a;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Navigation Styles */
        .admin-nav {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .nav-item {
            background: rgba(38, 166, 154, 0.1);
            border: 1px solid #b2dfdb;
            border-radius: 0.75rem;
            padding: 0.5rem 1rem;
            color: #26a69a;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-item:hover {
            background: #26a69a;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
        }

        .user-dropdown {
            position: relative;
        }

        .user-btn {
            background: linear-gradient(135deg, #26a69a, #00acc1);
            color: white;
            border: none;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .user-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.2);
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid #b2dfdb;
            border-radius: 1rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            min-width: 200px;
            margin-top: 0.5rem;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: #26a69a;
            text-decoration: none;
            transition: all 0.3s ease;
            border-bottom: 1px solid #f0f0f0;
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item:hover {
            background: rgba(38, 166, 154, 0.1);
            color: #00695c;
        }

        .dropdown-item.danger {
            color: #e53e3e;
        }

        .dropdown-item.danger:hover {
            background: rgba(229, 62, 62, 0.1);
        }

        /* Banner Section */
        .welcome-banner {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-radius: 1.5rem;
            padding: 2rem;
            margin: 2rem 0;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid #b2dfdb;
        }

        .welcome-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #00695c;
            margin-bottom: 0.5rem;
        }

        .welcome-subtitle {
            font-size: 1.25rem;
            color: #26a69a;
            margin: 0;
        }

        /* Action Section */
        .action-section {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-radius: 1.5rem;
            padding: 2rem;
            margin: 2rem 0;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            border: 1px solid #b2dfdb;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #00695c;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn-teal {
            background: linear-gradient(135deg, #26a69a, #00acc1);
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-teal:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.2);
            color: white;
        }

        .btn-outline-teal {
            background: transparent;
            border: 2px solid #26a69a;
            color: #26a69a;
            padding: 0.75rem 1.5rem;
            border-radius: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-outline-teal:hover {
            background: #26a69a;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        /* Filter Section */
        .filter-form {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(8px);
            border-radius: 1rem;
            padding: 1.5rem;
            border: 1px solid #b2dfdb;
        }

        .form-control,
        .form-select {
            border: 2px solid #b2dfdb;
            border-radius: 1rem;
            padding: 0.75rem 1rem;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #26a69a;
            box-shadow: 0 0 0 0.2rem rgba(38, 166, 154, 0.25);
            background: white;
        }

        .search-input {
            position: relative;
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #26a69a;
            z-index: 10;
        }

        .search-input input {
            padding-left: 3rem;
        }

        /* Book Cards */
        .book-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid #b2dfdb;
            border-radius: 1.5rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .book-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border-color: #26a69a;
        }

        .book-image {
            border-top-left-radius: 1.5rem;
            border-top-right-radius: 1.5rem;
            object-fit: cover;
            height: 200px;
            width: 100%;
        }

        .card-body {
            padding: 1.5rem;
        }

        .book-title {
            color: #00695c;
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 0.75rem;
        }

        .book-info {
            color: #26a69a;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .book-badge {
            background: rgba(38, 166, 154, 0.1);
            color: #26a69a;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 500;
            border: 1px solid #b2dfdb;
        }

        /* Modal Styles */
        .modal-content {
            border: none;
            border-radius: 1.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            backdrop-filter: blur(20px);
        }

        .modal-header {
            background: linear-gradient(135deg, #26a69a, #00acc1);
            color: white;
            border-radius: 1.5rem 1.5rem 0 0;
            border-bottom: none;
            padding: 1.5rem;
        }

        .modal-title {
            font-weight: bold;
        }

        .modal-body {
            padding: 2rem;
            background: rgba(255, 255, 255, 0.95);
        }

        .modal-footer {
            background: rgba(255, 255, 255, 0.95);
            border-top: 1px solid #b2dfdb;
            border-radius: 0 0 1.5rem 1.5rem;
            padding: 1.5rem;
        }

        .list-group-item {
            background: transparent;
            border: none;
            border-bottom: 1px solid #e0f2fe;
            padding: 0.75rem 0;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }

        /* Footer */
        .admin-footer {
            background: #26a69a;
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
        }

        .footer-content {
            background: #00695c;
            border-radius: 1.5rem;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-info h3 {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .footer-info p {
            color: #b2dfdb;
            margin: 0;
        }

        .footer-links {
            display: flex;
            gap: 1rem;
        }

        .footer-link {
            background: transparent;
            border: 1px solid white;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .footer-link:hover {
            background: white;
            color: #00695c;
        }

        /* Alert Styles */
        .alert-teal {
            background: rgba(38, 166, 154, 0.1);
            border: 1px solid #b2dfdb;
            color: #00695c;
            border-radius: 1rem;
            padding: 1.5rem;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeInUp 0.6s ease forwards;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                text-align: center;
            }

            .admin-nav {
                flex-wrap: wrap;
                justify-content: center;
            }

            .welcome-title {
                font-size: 2rem;
            }

            .footer-content {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
    <?php
    require_once __DIR__ . '/../../../vendor/autoload.php';
    require_once app_path('public/conex.php');
    ?>
</head>

<body>
    <!-- Header -->
    <header class="admin-header">
        <div class="container">
            <div class="header-content">
                <div class="admin-logo">
                    <div class="logo-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="logo-text">
                        <h1>Gestión de Libros</h1>
                        <p>Biblioteca Mágica</p>
                    </div>
                </div>

                <nav class="admin-nav">
                    <a href="<?= app_path("public/ABM/ABM_index.php") ?>" class="nav-item">
                        <i class="fas fa-home"></i>
                        Inicio
                    </a>
                    <div class="user-dropdown">
                        <button class="user-btn" onclick="toggleDropdown()">
                            <i class="fas fa-user-shield"></i>
                            Administrador
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" id="userDropdown">
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-user-cog"></i>
                                Mi Perfil
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-cog"></i>
                                Configuración
                            </a>
                            <a href="logout.php" class="dropdown-item danger" onclick="return confirm('¿Cerrar sesión?')">
                                <i class="fas fa-sign-out-alt"></i>
                                Cerrar Sesión
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- Welcome Banner -->
    <div class="container">
        <div class="welcome-banner fade-in">
            <h2 class="welcome-title">Administración de Biblioteca</h2>
            <p class="welcome-subtitle">Gestiona el catálogo de libros de forma eficiente</p>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="container">
        <div class="action-section fade-in">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <h3 class="section-title">
                        <i class="fas fa-tools"></i>
                        Acciones Rápidas
                    </h3>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="<?= app_path("public/ABM/ABM_index.php") ?>" class="btn-outline-teal me-3">
                        <i class="fas fa-arrow-left"></i>
                        Volver
                    </a>
                    <a href="<?= app_path("public/ABM/Libros/Añadir/ABM_libro_añadir.html") ?>" class="btn-teal">
                        <i class="fas fa-plus"></i>
                        Añadir Libro
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

    <!-- Filter Section -->
    <div class="container">
        <div class="action-section fade-in">
            <h3 class="section-title">
                <i class="fas fa-filter"></i>
                Filtros de Búsqueda
            </h3>
            <div class="filter-form">
                <form method="GET" action="<?= app_path("public/ABM/Libros/ABM_libro.php") ?>" class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <div class="search-input">
                            <i class="fas fa-search search-icon"></i>
                            <input
                                type="text"
                                name="buscar"
                                class="form-control"
                                placeholder="Buscar por título..."
                                value="<?php echo htmlspecialchars($busqueda); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="color" class="form-select">
                            <option value="">Todos los colores</option>
                            <?php while ($fila = $coloresRes->fetch_assoc()): ?>
                                <option value="<?php echo $fila['color']; ?>" <?php echo ($color === $fila['color']) ? 'selected' : ''; ?>>
                                    <?php echo $fila['color']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="genero" class="form-select">
                            <option value="">Todos los géneros</option>
                            <?php while ($fila = $generosRes->fetch_assoc()): ?>
                                <option value="<?php echo $fila['clasificacion']; ?>" <?php echo ($genero === $fila['clasificacion']) ? 'selected' : ''; ?>>
                                    <?php echo $fila['clasificacion']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn-teal w-100">
                            <i class="fas fa-search"></i>
                            Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Books Grid -->
    <div class="container pb-5">
        <div class="row g-4">
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
                        <div class="book-card h-100 fade-in">
                            <img
                                src="data:image/jpeg;base64,<?= $base64img; ?>"
                                class="book-image"
                                alt="Portada de <?= $titulo; ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="book-title text-truncate" title="<?= $titulo; ?>">
                                    <?= $titulo; ?>
                                </h5>
                                <p class="book-info mb-2">
                                    <strong>Género:</strong> <?= $clasificacion; ?>
                                </p>
                                <p class="book-info mb-3">
                                    <strong>Color:</strong> <span class="book-badge"><?= $colorPortada; ?></span>
                                </p>
                                <button
                                    type="button"
                                    class="btn-outline-teal mt-auto"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalLibro<?= $id; ?>">
                                    <i class="fas fa-eye"></i>
                                    Ver detalles
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for book <?= $titulo; ?> -->
                    <div
                        class="modal fade"
                        id="modalLibro<?= $id; ?>"
                        tabindex="-1"
                        aria-labelledby="modalLabel<?= $id; ?>"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel<?= $id; ?>">
                                        <i class="fas fa-book-open me-2"></i>
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
                                                class="img-fluid rounded-3"
                                                alt="Portada de <?= $titulo; ?>"
                                                style="border-radius: 1rem;">
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
                                                    <strong>Color:</strong> <span class="book-badge"><?= $colorPortada; ?></span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a
                                        href="<?= app_path("public/ABM/Libros/Editar/ABM_libro_edit.php") ?>?id=<?= $id; ?>"
                                        class="btn-outline-teal">
                                        <i class="fas fa-edit"></i>
                                        Editar
                                    </a>
                                    <a
                                        href="<?= app_path("public/ABM/Libros/ABM_libro_del.php") ?>?id=<?= $id; ?>"
                                        class="btn-outline-teal"
                                        style="border-color: #e53e3e; color: #e53e3e;"
                                        onmouseover="this.style.background='#e53e3e'; this.style.color='white';"
                                        onmouseout="this.style.background='transparent'; this.style.color='#e53e3e';">
                                        <i class="fas fa-trash"></i>
                                        Borrar
                                    </a>
                                    <button
                                        type="button"
                                        class="btn-outline-teal"
                                        data-bs-dismiss="modal">
                                        <i class="fas fa-times"></i>
                                        Cerrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert-teal text-center fade-in" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        No se encontraron libros con los criterios especificados.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="admin-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-info">
                    <h3>
                        <i class="fas fa-book"></i>
                        Biblioteca Mágica - Gestión
                    </h3>
                    <p>Jardín de Infantes "Pequeños Exploradores"</p>
                </div>
                <div class="footer-links">
                    <a href="#" class="footer-link">
                        <i class="fas fa-headset"></i>
                        Soporte Técnico
                    </a>
                    <a href="#" class="footer-link">
                        <i class="fas fa-book-open"></i>
                        Manual de Usuario
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Dropdown functionality
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const button = event.target.closest('.user-btn');

            if (!button && !dropdown.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });

        // Add fade-in animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe elements for animation
        document.querySelectorAll('.fade-in').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>

</html>