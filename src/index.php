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

        /* Floating Header */
        .header-wrapper {
            position: relative;
        }

        .floating-header {
            position: absolute;
            top: 1rem;
            left: 1rem;
            right: 1rem;
            z-index: 50;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border-radius: 1.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid #b2dfdb;
            padding: 1rem 1.5rem;
        }

        .header-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo-icon {
            background: linear-gradient(135deg, #26a69a, #00acc1);
            padding: 0.75rem;
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .logo-icon i {
            color: white;
            font-size: 1.75rem;
        }

        .logo-text h1 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #00695c;
        }

        .logo-text p {
            font-size: 0.75rem;
            color: #26a69a;
        }

        .search-section {
            flex: 1;
            max-width: 24rem;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 3rem;
            border-radius: 1rem;
            border: 2px solid #b2dfdb;
            background: rgba(255, 255, 255, 0.8);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #26a69a;
            box-shadow: 0 0 0 3px rgba(38, 166, 154, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #26a69a;
        }

        .login-btn {
            background: linear-gradient(135deg, #26a69a, #00acc1);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.2);
        }

        /* Hero Section */
        .hero-section {
            padding-top: 8rem;
            padding-bottom: 4rem;
            text-align: center;
        }

        .hero-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
            border-radius: 1.5rem;
            padding: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid #b2dfdb;
            max-width: 64rem;
            margin: 0 auto;
        }

        .hero-dots {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .dot {
            width: 1rem;
            height: 1rem;
            border-radius: 50%;
            animation: bounce 2s infinite;
        }

        .dot-1 {
            background-color: #f48fb1;
        }

        .dot-2 {
            background-color: #81c784;
            animation-delay: 0.1s;
        }

        .dot-3 {
            background-color: #64b5f6;
            animation-delay: 0.2s;
        }

        .dot-4 {
            background-color: #ffb74d;
            animation-delay: 0.3s;
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-10px);
            }

            60% {
                transform: translateY(-5px);
            }
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #00695c;
            margin-bottom: 1rem;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: #26a69a;
            margin-bottom: 1.5rem;
        }

        .hero-icons {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
        }

        .hero-icons i {
            font-size: 2rem;
            animation: pulse 2s infinite;
        }

        .icon-sparkles {
            color: #f48fb1;
        }

        .icon-star {
            color: #ffb74d;
            animation: spin 3s linear infinite;
        }

        .icon-heart {
            color: #f48fb1;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Clear Filters */
        .clear-filters {
            text-align: center;
            padding: 1.5rem 0;
        }

        .clear-btn {
            background: transparent;
            border: 2px solid #b2dfdb;
            color: #26a69a;
            padding: 0.75rem 1.5rem;
            border-radius: 1rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .clear-btn:hover {
            background: #e0f2f1;
        }

        /* Genre Categories */
        .genres-section {
            padding: 2rem 0;
        }

        .genres-title {
            font-size: 2rem;
            font-weight: bold;
            color: #00695c;
            text-align: center;
            margin-bottom: 2rem;
        }

        .genres-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
        }

        .genre-card {
            height: 16rem;
            border-radius: 1.5rem;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            border: 4px solid white;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-decoration: none;
            color: inherit;
        }

        .genre-card:hover {
            transform: scale(1.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .genre-card.selected {
            transform: scale(1.1);
            border-color: #26a69a;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .genre-cuentos {
            background: linear-gradient(135deg, #fce4ec, #f8bbd9);
        }

        .genre-fabulas {
            background: linear-gradient(135deg, #e8f5e8, #c8e6c9);
        }

        .genre-poesia {
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        }

        .genre-aventuras {
            background: linear-gradient(135deg, #fff3e0, #ffcc02);
        }

        .genre-naturaleza {
            background: linear-gradient(135deg, #f1f8e9, #dcedc8);
        }

        .genre-icon-wrapper {
            flex-shrink: 0;
        }

        .genre-icon {
            background: white;
            border-radius: 50%;
            width: 5rem;
            height: 5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .genre-icon i {
            font-size: 2.25rem;
        }

        .icon-cuentos {
            color: #c2185b;
        }

        .icon-fabulas {
            color: #388e3c;
        }

        .icon-poesia {
            color: #1976d2;
        }

        .icon-aventuras {
            color: #f57c00;
        }

        .icon-naturaleza {
            color: #689f38;
        }

        .genre-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .genre-title {
            font-size: 1.125rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: #424242;
        }

        .genre-description {
            color: #666;
            font-size: 0.875rem;
            line-height: 1.4;
        }

        .genre-selected {
            flex-shrink: 0;
            margin-top: 0.75rem;
        }

        .selected-badge {
            background: #26a69a;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* Books Section */
        .books-section {
            padding: 0 0 3rem 0;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #00695c;
            text-align: center;
            margin-bottom: 2rem;
        }

        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1.5rem;
        }

        .book-card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            border: 4px solid #b2dfdb;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .book-card:hover {
            transform: scale(1.05);
            border-color: #26a69a;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .book-cover {
            background: linear-gradient(135deg, #26a69a, #00acc1);
            height: 9rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            padding: 0.75rem;
        }

        .book-cover i {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .book-cover img {
            max-height: 100%;
            max-width: 100%;
            object-fit: cover;
        }

        .book-info {
            padding: 1rem;
            background: linear-gradient(to bottom, white, #f9f9f9);
        }

        .book-title {
            font-weight: bold;
            font-size: 1rem;
            color: #424242;
            margin-bottom: 0.25rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: color 0.3s ease;
        }

        .book-card:hover .book-title {
            color: #26a69a;
        }

        .book-author {
            color: #666;
            font-size: 0.875rem;
        }

        /* No Results */
        .no-results {
            text-align: center;
            padding: 4rem 0;
        }

        .no-results-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
            border-radius: 1.5rem;
            padding: 2rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            border: 1px solid #b2dfdb;
            max-width: 24rem;
            margin: 0 auto;
        }

        .no-results i {
            font-size: 4rem;
            color: #26a69a;
            margin-bottom: 1rem;
        }

        .no-results h3 {
            font-size: 1.25rem;
            font-weight: bold;
            color: #00695c;
            margin-bottom: 0.5rem;
        }

        .no-results p {
            color: #26a69a;
        }

        /* Footer */
        .footer {
            background: #26a69a;
            color: white;
            padding: 2rem 0;
        }

        .footer-content {
            background: #00695c;
            border-radius: 1.5rem;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
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
        }

        .footer-subtitle {
            color: #4db6ac;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .footer-buttons {
            display: flex;
            gap: 0.75rem;
        }

        .footer-btn {
            background: transparent;
            border: 1px solid white;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 1rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-btn:hover {
            background: white;
            color: #00695c;
        }

        /* Responsive Design */
        @media (min-width: 768px) {
            .header-content {
                flex-direction: row;
            }

            .hero-title {
                font-size: 3rem;
            }

            .hero-subtitle {
                font-size: 1.5rem;
            }

            .genres-grid {
                grid-template-columns: repeat(5, 1fr);
            }

            .footer-content {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }

            .footer-info {
                text-align: left;
            }
        }

        @media (min-width: 1024px) {
            .logo-text h1 {
                font-size: 1.75rem;
            }

            .genres-title {
                font-size: 2.5rem;
            }

            .books-grid {
                grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            }
        }
    </style>
</head>

<body>
    <!-- Floating Header -->
    <div class="header-wrapper">
        <div class="floating-header">
            <div class="header-content">
                <!-- Logo -->
                <div class="logo-section">
                    <div class="logo-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="logo-text">
                        <h1>Biblioteca Mágica</h1>
                        <p>Pequeños Exploradores</p>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="search-section">
                    <form action="index.php" method="GET">
                        <div style="position: relative;">
                            <i class="fas fa-search search-icon"></i>
                            <input
                                type="text"
                                name="buscar"
                                class="search-input"
                                placeholder="¿Qué libro buscas?"
                                value="<?php echo htmlspecialchars($buscar); ?>">
                            <?php if ($generoSeleccionado): ?>
                                <input type="hidden" name="genero" value="<?php echo htmlspecialchars($generoSeleccionado); ?>">
                            <?php endif; ?>
                        </div>
                    </form>
                </div>

                <!-- Login Button -->
                <a href="Usuarios/login.php" class="login-btn">
                    <i class="fas fa-user"></i>
                    Entrar
                </a>
            </div>
        </div>

        <!-- Hero Section -->
        <div class="hero-section">
            <div class="container">
                <div class="hero-card">
                    <div class="hero-dots">
                        <div class="dot dot-1"></div>
                        <div class="dot dot-2"></div>
                        <div class="dot dot-3"></div>
                        <div class="dot dot-4"></div>
                    </div>
                    <h2 class="hero-title">¡Descubre Mundos Increíbles!</h2>
                    <p class="hero-subtitle">Cada libro es una nueva aventura esperándote</p>
                    <div class="hero-icons">
                        <i class="fas fa-sparkles icon-sparkles"></i>
                        <i class="fas fa-star icon-star"></i>
                        <i class="fas fa-heart icon-heart"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Clear Filters -->
    <?php if ($buscar || $generoSeleccionado): ?>
        <div class="clear-filters">
            <div class="container">
                <a href="index.php" class="clear-btn">
                    <i class="fas fa-home"></i>
                    Ver todos los libros
                </a>
            </div>
        </div>
    <?php endif; ?>

    <!-- Genre Categories -->
    <div class="genres-section">
        <div class="container">
            <h2 class="genres-title">Elige tu Aventura Favorita</h2>
            <div class="genres-grid">
                <?php foreach ($generos as $index => $genero): ?>
                    <?php
                    $isSelected = $generoSeleccionado === $genero;
                    $classes = ['genre-cuentos', 'genre-fabulas', 'genre-poesia', 'genre-aventuras', 'genre-naturaleza'];
                    $icons = ['fas fa-sparkles', 'fas fa-heart', 'fas fa-star', 'fas fa-compass', 'fas fa-leaf'];
                    $iconClasses = ['icon-cuentos', 'icon-fabulas', 'icon-poesia', 'icon-aventuras', 'icon-naturaleza'];
                    $descriptions = [
                        'Historias mágicas con princesas, hadas y dragones',
                        'Relatos con animales que enseñan valores',
                        'Versos, rimas y canciones para los más pequeños',
                        'Historias emocionantes de exploración y descubrimiento',
                        'Cuentos sobre plantas, animales y el mundo natural'
                    ];
                    ?>
                    <a href="?genero=<?php echo urlencode($genero); ?><?php echo $buscar ? '&buscar=' . urlencode($buscar) : ''; ?>"
                        class="genre-card <?php echo $classes[$index]; ?> <?php echo $isSelected ? 'selected' : ''; ?>">
                        <div class="genre-icon-wrapper">
                            <div class="genre-icon">
                                <i class="<?php echo $icons[$index]; ?> <?php echo $iconClasses[$index]; ?>"></i>
                            </div>
                        </div>
                        <div class="genre-content">
                            <h3 class="genre-title"><?php echo htmlspecialchars($genero); ?></h3>
                            <p class="genre-description"><?php echo $descriptions[$index]; ?></p>
                        </div>
                        <?php if ($isSelected): ?>
                            <div class="genre-selected">
                                <span class="selected-badge">✨ Seleccionado</span>
                            </div>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Books Display -->
    <div class="books-section">
        <div class="container">
            <?php if ($buscar): ?>
                <h2 class="section-title">Buscaste: "<?php echo htmlspecialchars($buscar); ?>"</h2>
            <?php endif; ?>

            <?php if ($generoSeleccionado): ?>
                <h2 class="section-title"><?php echo htmlspecialchars($generoSeleccionado); ?></h2>
            <?php endif; ?>

            <?php
            // Construir consulta SQL
            if ($generoSeleccionado) {
                $sql = "SELECT titulo, autor, imagen FROM libros WHERE clasificacion='" . $conn->real_escape_string($generoSeleccionado) . "' $whereBuscar";
            } elseif ($buscar) {
                $sql = "SELECT titulo, autor, imagen FROM libros WHERE (titulo LIKE '%$buscar%' OR autor LIKE '%$buscar%')";
            } else {
                $sql = "SELECT titulo, autor, imagen FROM libros";
            }

            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0):
            ?>
                <div class="books-grid">
                    <?php while ($libro = $result->fetch_assoc()): ?>
                        <?php
                        $imageSrc = !empty($libro['imagen'])
                            ? 'data:image/jpeg;base64,' . base64_encode($libro['imagen'])
                            : null;
                        ?>
                        <div class="book-card">
                            <div class="book-cover">
                                <?php if ($imageSrc): ?>
                                    <img src="<?php echo $imageSrc; ?>" alt="<?php echo htmlspecialchars($libro['titulo']); ?>">
                                <?php else: ?>
                                    <div>
                                        <i class="fas fa-book"></i>
                                        <div style="font-size: 0.75rem; font-weight: 500;">Sin imagen</div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="book-info">
                                <h3 class="book-title"><?php echo htmlspecialchars($libro['titulo']); ?></h3>
                                <p class="book-author"><?php echo htmlspecialchars($libro['autor']); ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="no-results">
                    <div class="no-results-card">
                        <i class="fas fa-book"></i>
                        <h3>¡Ups!</h3>
                        <p>No encontramos libros con esa búsqueda.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-info">
                    <h3>
                        <i class="fas fa-book"></i>
                        Biblioteca Mágica
                    </h3>
                    <p>Jardín de Infantes "Pequeños Exploradores"</p>
                    <p class="footer-subtitle">Donde cada historia cobra vida</p>
                </div>
                <div class="footer-buttons">
                    <a href="#" class="footer-btn">Contacto</a>
                    <a href="#" class="footer-btn">Ayuda</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Auto-submit search form on input (optional)
        const searchInput = document.querySelector('input[name="buscar"]');
        let searchTimeout;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                // Uncomment the next line if you want auto-search
                // this.form.submit();
            }, 500);
        });

        // Add loading state to genre cards
        document.querySelectorAll('.genre-card').forEach(card => {
            card.addEventListener('click', function() {
                this.style.opacity = '0.7';
                this.style.transform = 'scale(1.05)';
            });
        });

        // Intersection Observer for animations
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

        // Observe book cards for scroll animations
        document.querySelectorAll('.book-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });
    </script>
</body>

</html>