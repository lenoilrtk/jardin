<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Libro - Biblioteca Mágica</title>
    
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

        /* Admin Header */
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

        .user-info {
            background: linear-gradient(135deg, #26a69a, #00acc1);
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        /* Main Content */
        .main-content {
            padding: 3rem 0;
        }

        .page-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .page-title h2 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #00695c;
            margin-bottom: 0.5rem;
        }

        .page-title p {
            font-size: 1.25rem;
            color: #26a69a;
        }

        /* Book Info Header */
        .book-info-header {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            border-radius: 1.5rem;
            padding: 2rem;
            margin-bottom: 2rem;
            text-align: center;
            border: 2px solid #93c5fd;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .book-info-header h3 {
            color: #00695c;
            font-weight: bold;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 1.5rem;
        }

        .book-info-header p {
            color: #26a69a;
            margin: 0;
            font-size: 1.1rem;
        }

        /* Form Container */
        .form-container {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-radius: 1.5rem;
            padding: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid #b2dfdb;
            margin-bottom: 2rem;
        }

        /* Form Sections */
        .form-section {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid #e2e8f0;
        }

        .section-title {
            color: #00695c;
            font-weight: bold;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.25rem;
        }

        .section-title i {
            color: #26a69a;
            font-size: 1.2rem;
        }

        /* Form Elements */
        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-label i {
            color: #26a69a;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.75rem;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            font-size: 0.875rem;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .form-control:focus {
            outline: none;
            border-color: #26a69a;
            box-shadow: 0 0 0 3px rgba(38, 166, 154, 0.1);
        }

        .form-control.is-invalid {
            border-color: #dc2626;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        /* Grid Layout */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -0.5rem;
        }

        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 0 0.5rem;
        }

        .mb-3 {
            margin-bottom: 1rem;
        }

        /* Preview Container */
        .preview-container {
            background: linear-gradient(135deg, #fef3c7, #fed7aa);
            border-radius: 1rem;
            padding: 1.5rem;
            text-align: center;
            margin-top: 1rem;
            border: 2px solid #fbbf24;
        }

        .preview-container h5 {
            color: #92400e;
            font-weight: bold;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .image-preview {
            max-width: 150px;
            max-height: 200px;
            border-radius: 0.5rem;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            margin: 0 auto;
            display: block;
            object-fit: cover;
        }

        /* Buttons */
        .btn-action {
            background: linear-gradient(135deg, #26a69a, #00acc1);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            margin: 0.5rem;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.2);
            color: white;
        }

        .btn-secondary {
            background: rgba(108, 117, 125, 0.1);
            color: #6c757d;
            border: 1px solid #6c757d;
        }

        .btn-secondary:hover {
            background: #6c757d;
            color: white;
        }

        /* Error Message */
        .error-message {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            text-align: center;
            color: #dc2626;
            border: 2px solid #ef4444;
        }

        .error-message i {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
        }

        .error-message h3 {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
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

            .page-title h2 {
                font-size: 2rem;
            }

            .col-md-6 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .footer-content {
                flex-direction: column;
                text-align: center;
            }
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
    </style>
</head>
<body>
    <!-- Admin Header -->
    <header class="admin-header">
        <div class="container">
            <div class="header-content">
                <div class="admin-logo">
                    <div class="logo-icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    <div class="logo-text">
                        <h1>Modificar Libro</h1>
                        <p>Biblioteca Mágica</p>
                    </div>
                </div>

                <nav class="admin-nav">
                    <a href="ABM_index.php" class="nav-item">
                        <i class="fas fa-home"></i>
                        Inicio
                    </a>
                    <div class="user-info">
                        <i class="fas fa-user-shield"></i>
Administrador   
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- Page Title -->
    <div class="main-content">
        <div class="container">
            <div class="page-title fade-in">
                <h2>Editar Información del Libro</h2>
                <p>Actualiza los datos del libro en el catálogo</p>
            </div>

            <?php
            include "./conex.php";
            
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                echo '<div class="error-message fade-in">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h3>Error: ID de libro no especificado</h3>
                        <p>No se ha proporcionado un ID válido para el libro.</p>
                        <a href="./ABM_libro.php" class="btn-action">
                            <i class="fas fa-arrow-left"></i>
                            Volver a la Lista
                        </a>
                      </div>';
                exit;
            }
            
            $id = intval($_GET['id']);
            $sql = "SELECT * FROM `libros` WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
            ?>
            
            <!-- Book Info Header -->
            <div class="book-info-header fade-in">
                <h3>
                    <i class="fas fa-book"></i>
                    Editando: <?php echo htmlspecialchars($row["titulo"]); ?>
                </h3>
                <p>ID del libro: #<?php echo $row["id"]; ?></p>
            </div>

            <div class="form-container fade-in">
                <form action="ABM_libro_edit_mod.php?libro_id=<?php echo $row["id"]; ?>" method="POST" id="editBookForm" enctype="multipart/form-data">
                    
                    <!-- Información Básica -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-book"></i>
                            Información Básica del Libro
                        </h3>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="titulo" class="form-label">
                                    <i class="fas fa-heading"></i>
                                    Título
                                </label>
                                <input type="text" class="form-control" id="titulo" name="titulo" 
                                       value="<?php echo htmlspecialchars($row["titulo"]); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="autor" class="form-label">
                                    <i class="fas fa-user-edit"></i>
                                    Autor
                                </label>
                                <input type="text" class="form-control" id="autor" name="autor" 
                                       value="<?php echo htmlspecialchars($row["autor"]); ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="ilustrador" class="form-label">
                                    <i class="fas fa-palette"></i>
                                    Ilustrador
                                </label>
                                <input type="text" class="form-control" id="ilustrador" name="ilustrador" 
                                       value="<?php echo htmlspecialchars($row["ilustrador"]); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editorial" class="form-label">
                                    <i class="fas fa-building"></i>
                                    Editorial
                                </label>
                                <input type="text" class="form-control" id="editorial" name="editorial" 
                                       value="<?php echo htmlspecialchars($row["editorial"]); ?>" required>
                            </div>
                        </div>
                    </div>

                    <!-- Clasificación y Características -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-tags"></i>
                            Clasificación y Características
                        </h3>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="clasificacion" class="form-label">
                                    <i class="fas fa-bookmark"></i>
                                    Clasificación
                                </label>
                                <select class="form-control" id="clasificacion" name="clasificacion" required>
                                    <option value="">Selecciona una clasificación</option>
                                    <option value="Cuentos de Hadas" <?php echo ($row["clasificacion"] == "Cuentos de Hadas") ? "selected" : ""; ?>>Cuentos de Hadas</option>
                                    <option value="Fábulas con Animales" <?php echo ($row["clasificacion"] == "Fábulas con Animales") ? "selected" : ""; ?>>Fábulas con Animales</option>
                                    <option value="Poesía Infantil" <?php echo ($row["clasificacion"] == "Poesía Infantil") ? "selected" : ""; ?>>Poesía Infantil</option>
                                    <option value="Libros de Aventuras" <?php echo ($row["clasificacion"] == "Libros de Aventuras") ? "selected" : ""; ?>>Libros de Aventuras</option>
                                    <option value="Historias de la Naturaleza" <?php echo ($row["clasificacion"] == "Historias de la Naturaleza") ? "selected" : ""; ?>>Historias de la Naturaleza</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="color" class="form-label">
                                    <i class="fas fa-circle"></i>
                                    Color Identificativo
                                </label>
                                <select class="form-control" id="color" name="color" required>
                                    <option value="">Selecciona un color</option>
                                    <option value="Rojo" <?php echo ($row["color"] == "Rojo") ? "selected" : ""; ?>>🔴 Rojo</option>
                                    <option value="Azul" <?php echo ($row["color"] == "Azul") ? "selected" : ""; ?>>🔵 Azul</option>
                                    <option value="Verde" <?php echo ($row["color"] == "Verde") ? "selected" : ""; ?>>🟢 Verde</option>
                                    <option value="Amarillo" <?php echo ($row["color"] == "Amarillo") ? "selected" : ""; ?>>🟡 Amarillo</option>
                                    <option value="Rosa" <?php echo ($row["color"] == "Rosa") ? "selected" : ""; ?>>🌸 Rosa</option>
                                    <option value="Morado" <?php echo ($row["color"] == "Morado") ? "selected" : ""; ?>>🟣 Morado</option>
                                    <option value="Naranja" <?php echo ($row["color"] == "Naranja") ? "selected" : ""; ?>>🟠 Naranja</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Descripción e Imagen -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-image"></i>
                            Descripción e Imagen
                        </h3>
                        <div class="mb-3">
                            <label for="resumen" class="form-label">
                                <i class="fas fa-align-left"></i>
                                Resumen
                            </label>
                            <textarea class="form-control" id="resumen" name="resumen" rows="4" required><?php echo htmlspecialchars($row["resumen"]); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="imagen" class="form-label">
                                <i class="fas fa-camera"></i>
                                Imagen del Libro
                            </label>
                            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" onchange="previewImage()">
                            <div class="preview-container">
                                <h5>
                                    <i class="fas fa-eye"></i>
                                    Vista Previa Actual
                                </h5>
                                <img id="previewImg" class="image-preview" src="data:image/jpeg;base64,<?php echo base64_encode($row['imagen']); ?>" alt="Vista previa del libro" onerror="this.src='/placeholder.svg?height=200&width=150&text=Sin+Imagen'">
                            </div>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div style="text-align: center;">
                        <a href="./ABM_libro.php" class="btn-action btn-secondary">
                            <i class="fas fa-times"></i>
                            Cancelar
                        </a>
                        <button type="submit" class="btn-action">
                            <i class="fas fa-save"></i>
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
            
            <?php 
            } else {
                echo '<div class="error-message fade-in">
                        <i class="fas fa-book-dead"></i>
                        <h3>Libro no encontrado</h3>
                        <p>No se encontró ningún libro con el ID especificado.</p>
                        <a href="./ABM_libro.php" class="btn-action">
                            <i class="fas fa-arrow-left"></i>
                            Volver a la Lista
                        </a>
                      </div>';
            }
            $conn->close();
            ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="admin-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-info">
                    <h3>
                        <i class="fas fa-edit"></i>
                        Gestión de Edición
                    </h3>
                    <p>Biblioteca Mágica - Jardín de Infantes "Pequeños Exploradores"</p>
                </div>
                <div class="footer-links">
                    <a href="#" class="footer-link">
                        <i class="fas fa-question-circle"></i>
                        Ayuda
                    </a>
                    <a href="#" class="footer-link">
                        <i class="fas fa-headset"></i>
                        Soporte
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Función para mostrar vista previa de la imagen
        function previewImage() {
            const input = document.getElementById('imagen');
            const previewImg = document.getElementById('previewImg');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Validación del formulario antes de enviar
        document.getElementById('editBookForm').addEventListener('submit', function(e) {
            const requiredFields = ['titulo', 'autor', 'ilustrador', 'editorial', 'clasificacion', 'color', 'resumen'];
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
            if (!confirm('¿Estás seguro de que quieres guardar los cambios en este libro?')) {
                e.preventDefault();
                return false;
            }
        });

        // Add fade-in animation on load
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.fade-in');
            elements.forEach((el, index) => {
                setTimeout(() => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 200);
            });
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
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
