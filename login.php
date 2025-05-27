<?php
// login.php
session_start();
include 'ABM/conex.php';  // Conexión a BDD

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $conn->real_escape_string($_POST['email']);
    $pass   = $_POST['password'];

    // Buscar usuario por correo
    $sql  = "SELECT usuario_id, contraseña, nivel FROM usuarios WHERE correo = '$correo' LIMIT 1";
    $res  = $conn->query($sql);

    if ($res && $res->num_rows === 1) {
        $user = $res->fetch_assoc();
        // Comparar contraseña en texto plano
        if ($pass === $user['contraseña']) {
            // Login correcto
            $_SESSION['usuario_id'] = $user['usuario_id'];
            $_SESSION['nivel']      = $user['nivel'];
            // Redirección según nivel: 1 y 2 a ABM, 3 a frontend
            if ($user['nivel'] == 1 || $user['nivel'] == 2) {
                header('Location: ABM/ABM_index.php');
            } else {
                header('Location: index.php');
            }
            exit;
        } else {
            $error = 'Contraseña incorrecta.';
        }
    } else {
        $error = 'No existe una cuenta con ese correo.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Acceso - Biblioteca Mágica</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Tus estilos personalizados -->
  <link rel="stylesheet" href="styles/login.css">
</head>
<body class="d-flex flex-column min-vh-100">
  <!-- Encabezado -->
  <header class="header-gradient py-3 shadow">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 d-flex align-items-center">
          <div class="bg-white p-2 rounded-circle me-3">
            <i class="fas fa-book fs-4 text-purple"></i>
          </div>
          <h1 class="fs-2 fw-bold text-white mb-0">Biblioteca Mágica</h1>
        </div>
        <div class="col-md-6 text-md-end">
          <a href="index.php" class="btn btn-outline-light">
            <i class="fas fa-home me-2"></i>Volver al Inicio
          </a>
        </div>
      </div>
    </div>
  </header>

  <!-- Mensaje de error -->
  <?php if ($error): ?>
    <div class="container mt-4">
      <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
    </div>
  <?php endif; ?>

  <!-- Contenido principal -->
  <div class="container py-5 flex-grow-1">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="flip-container">
          <div class="flipper" id="flipper">

            <!-- Lado frontal: Login -->
            <div class="front">
              <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-purple text-white text-center py-3">
                  <h2 class="fs-3 fw-bold mb-0">Iniciar Sesión</h2>
                </div>
                <div class="card-body p-4">
                  <form method="POST" action="login.php">
                    <div class="mb-3">
                      <label for="email" class="form-label fw-medium">Correo Electrónico</label>
                      <div class="input-group">
                        <span class="input-group-text bg-purple-light border-0">
                          <i class="fas fa-envelope text-purple"></i>
                        </span>
                        <input type="email" name="email" id="email" class="form-control border-0 bg-light" placeholder="ejemplo@correo.com" required>
                      </div>
                    </div>
                    <div class="mb-4">
                      <label for="password" class="form-label fw-medium">Contraseña</label>
                      <div class="input-group">
                        <span class="input-group-text bg-purple-light border-0">
                          <i class="fas fa-lock text-purple"></i>
                        </span>
                        <input type="password" name="password" id="password" class="form-control border-0 bg-light" placeholder="Tu contraseña" required>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-purple w-100 py-2 rounded-pill mb-3">Iniciar Sesión</button>
                    <div class="text-center">
                      <p class="mb-0">
                        ¿No tienes una cuenta?
                        <a href="#" id="showSignup" class="text-purple fw-medium text-decoration-none">Crear cuenta</a>
                      </p>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Lado trasero: Registro -->
            <div class="back">
              <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-green text-white text-center py-3">
                  <h2 class="fs-3 fw-bold mb-0">Crear Cuenta</h2>
                </div>
                <div class="card-body p-4">
                  <form method="POST" action="registro.php">
                    <div class="mb-3">
                      <label for="nombre" class="form-label fw-medium">Nombre</label>
                      <input type="text" name="nombre" id="nombre" class="form-control border-0 bg-light" required>
                    </div>
                    <div class="mb-3">
                      <label for="apellido" class="form-label fw-medium">Apellido</label>
                      <input type="text" name="apellido" id="apellido" class="form-control border-0 bg-light" required>
                    </div>
                    <div class="mb-3">
                      <label for="documento" class="form-label fw-medium">Documento (DNI)</label>
                      <input type="text" name="documento" id="documento" class="form-control border-0 bg-light" required>
                    </div>
                    <div class="mb-3">
                      <label for="signup-email" class="form-label fw-medium">Correo Electrónico</label>
                      <input type="email" name="email" id="signup-email" class="form-control border-0 bg-light" required>
                    </div>
                    <div class="mb-3">
                      <label for="signup-password" class="form-label fw-medium">Contraseña</label>
                      <input type="password" name="password" id="signup-password" class="form-control border-0 bg-light" required>
                    </div>
                    <div class="mb-3">
                      <label for="nivel" class="form-label fw-medium">Nivel de Usuario</label>
                      <select name="nivel" id="nivel" class="form-select" required>
                        <option value="1">1 - Básico</option>
                        <option value="2">2 - Encargado</option>
                        <option value="3">3 - Administrador</option>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-green w-100 py-2 rounded-pill mb-3">Crear Cuenta</button>
                    <div class="text-center">
                      <p class="mb-0">
                        ¿Ya tienes cuenta?
                        <a href="#" id="showLogin" class="text-green fw-medium text-decoration-none">Iniciar sesión</a>
                      </p>
                    </div>
                  </form>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Pie de página -->
  <footer class="bg-purple-dark text-white py-4 mt-auto text-center">
    <p class="mb-0">Biblioteca Mágica — Jardín de Infantes "Pequeños Exploradores"</p>
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const flipper = document.getElementById('flipper');
      document.getElementById('showSignup').onclick = e => { e.preventDefault(); flipper.classList.add('flip'); };
      document.getElementById('showLogin').onclick  = e => { e.preventDefault(); flipper.classList.remove('flip'); };
    });
  </script>
</body>
</html>
