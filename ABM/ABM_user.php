<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - Biblioteca Mágica</title>
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
        
        .table-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .table thead th {
            background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
            color: white;
            border: none;
            font-weight: 600;
            padding: 15px 10px;
        }
        
        .table tbody tr:hover {
            background-color: #f8fafc;
        }
        
        .table tbody td {
            padding: 12px 10px;
            vertical-align: middle;
        }
        
        .btn-action {
            padding: 5px 12px;
            font-size: 0.875rem;
            border-radius: 20px;
        }
        
        .pagination-container {
            background: linear-gradient(135deg, #f3e8ff 0%, #e0e7ff 100%);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .action-buttons {
            background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .user-type-badge {
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.875rem;
            font-weight: 600;
        }
        
        .admin-badge {
            background-color: #dc2626;
            color: white;
        }
        
        .user-badge {
            background-color: #059669;
            color: white;
        }
        
        .password-field {
            font-family: monospace;
            letter-spacing: 2px;
        }
        
        .stats-container {
            background: linear-gradient(135deg, #f3e8ff 0%, #e0e7ff 100%);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
        }
    </style>
    <?php include "./conex.php" ?>
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
                    <div class="position-relative">
                        <i class="fas fa-search position-absolute search-icon text-muted"></i>
                        <input type="text" class="form-control rounded-pill py-2 ps-5" placeholder="Buscar usuarios..." id="searchUsers">
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
            <h2 class="display-5 fw-bold text-purple mb-2">Administración de Usuarios</h2>
            <p class="fs-5 text-purple-dark">Gestiona las cuentas y permisos del sistema</p>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="container py-4">
        <div class="stats-container">
            <div class="row g-4">


    <!-- Botones de acción -->
    <div class="container">
        <div class="action-buttons">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <h3 class="fs-4 fw-bold text-purple mb-0">
                        <i class="fas fa-tools me-2"></i>Acciones Rápidas
                    </h3>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="./ABM_index.html" class="btn btn-outline-secondary rounded-pill me-2">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Paginación -->
    <div class="container">
        <div class="pagination-container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <h4 class="fs-5 fw-bold text-purple mb-0">
                        <i class="fas fa-list me-2"></i>Seleccionar Página
                    </h4>
                </div>
                <div class="col-md-6">
                    <?php
                    $limite = 10;
                    echo '
                    <form action="ABM_user.php" method="GET" class="d-flex gap-2">
                        <select class="form-select rounded-pill" name="pagina">
                            <option value="1">Página 1</option>
                            <option value="2">Página 2</option>
                            <option value="3">Página 3</option>
                            <option value="4">Página 4</option>
                            <option value="5">Página 5</option>
                        </select>
                        <button type="submit" class="btn btn-purple rounded-pill px-4">
                            <i class="fas fa-search me-2"></i>Buscar
                        </button>
                    </form>';
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de usuarios -->
    <div class="container pb-5">
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">
                                <i class="fas fa-hashtag me-2"></i>ID
                            </th>
                            <th scope="col">
                                <i class="fas fa-user me-2"></i>Nombre
                            </th>
                             <th scope="col">
                                <i class="fas fa-user me-2"></i>apellido
                            </th>
                             <th scope="col">
                                <i class="fas fa-user me-2"></i>Correo
                            </th>
                            <th scope="col">
                                <i class="fas fa-key me-2"></i>Contraseña
                            </th>
                            <th scope="col">
                                <i class="fas fa-users me-2"></i>Documento
                            <th scope="col">
                                <i class="fas fa-user-tag me-2"></i>Tipo
                            </th>
                            <th scope="col" class="text-center">
                                <i class="fas fa-edit me-2"></i>Modificar
                            </th>
                            <th scope="col" class="text-center">
                                <i class="fas fa-trash me-2"></i>Eliminar
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $lista = 1;
                        $limite = 10;
                        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : $lista;
                        $offset = ($pagina - 1) * $limite;

                        $sql = "SELECT * FROM usuarios LIMIT $limite OFFSET $offset";
                        $result = $conn->query($sql);

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {

                                
                                // Determinar clase de badge según tipo
                                if ($row["nivel"] == "1") {
                                    $badgeClass = "admin-badge";
                                    $tipoIcon = "fas fa-user-shield";
                                } else if ($row["nivel"] == "2") {
                                    $badgeClass = "admin-badge";
                                    $tipoIcon = "fas fa-user-tie";
                                } else if ($row["nivel"] == "3") {
                                    $badgeClass = "user-badge";
                                    $tipoIcon = "fas fa-user";
                                } else {
                                    $badgeClass = "user-badge";
                                    $tipoIcon = "fas fa-user";
                                }

                                
                                echo '
                                <tr>
                                    <th scope="row" class="text-center fw-bold text-purple">' . $row["usuario_id"] . '</th>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="' . $tipoIcon . ' me-2 text-purple"></i>
                                            <span class="fw-medium">' . htmlspecialchars($row["nombre"]) . '</span>
                                        </div>
                                    </td>
                                       <td>
                                        <span>' . htmlspecialchars($row["apellido"]) . '</span>
                                    </td>
                                       <td>
                                        <span>' . htmlspecialchars($row["correo"]) . '</span>
                                    </td>
                                    <td>
                                        <span>' . htmlspecialchars($row["contraseña"]) . '</span>
                                    </td>
                                                                           <td>
                                        <span>' . htmlspecialchars($row["documento"]) . '</span>
                                    </td>
                                    <td>
                                        <span class="user-type-badge ' . $badgeClass . '">
                                            <i class="' . $tipoIcon . ' me-1"></i>
                                            ' . ucfirst($row["nivel"]) . '
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <a href="./ABM_user_edit.php?id=' . $row["usuario_id"] . '" class="btn btn-sm btn-outline-primary btn-action">
                                            <i class="fas fa-edit me-1"></i>Editar
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a href="./ABM_user_del.php?id=' . $row["usuario_id"] . '" class="btn btn-sm btn-outline-danger btn-action" 
                                           onclick="return confirm(\'¿Estás seguro de que quieres eliminar al usuario: ' . htmlspecialchars($row["usuario_id"]) . '?\')">
                                            <i class="fas fa-trash me-1"></i>Borrar
                                        </a>
                                    </td>  
                                </tr>';
                            }
                        } 
                        ?>
                    </tbody>
                </table>
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
        // Función para mostrar/ocultar contraseña
        function togglePassword(userId) {
            const passwordField = document.querySelector(`tr:has(th:contains("${userId}")) .password-field`);
            const realPassword = document.getElementById(`realpass-${userId}`);
            const button = event.target.closest('button');
            const icon = button.querySelector('i');
            
            if (realPassword.style.display === 'none') {
                // Mostrar contraseña real
                passwordField.style.display = 'none';
                realPassword.style.display = 'inline';
                icon.className = 'fas fa-eye-slash';
                button.title = 'Ocultar contraseña';
            } else {
                // Ocultar contraseña
                passwordField.style.display = 'inline';
                realPassword.style.display = 'none';
                icon.className = 'fas fa-eye';
                button.title = 'Ver contraseña';
            }
        }

        // Función de búsqueda en tiempo real
        document.getElementById('searchUsers').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('tbody tr');
            
            tableRows.forEach(row => {
                const userData = row.textContent.toLowerCase();
                if (userData.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Función para filtrar por tipo de usuario
        function filterByType(type) {
            const tableRows = document.querySelectorAll('tbody tr');
            
            tableRows.forEach(row => {
                if (type === 'all') {
                    row.style.display = '';
                } else {
                    const userType = row.querySelector('.user-type-badge').textContent.toLowerCase();
                    if (userType.includes(type)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        }
    </script>
</body>
</html>