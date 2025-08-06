<?php
// registro.php
session_start();
include '../ABM/conex.php';  // Ajusta la ruta si es necesario

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre    = $conn->real_escape_string($_POST['nombre']);
  $apellido  = $conn->real_escape_string($_POST['apellido']);
  $documento = $conn->real_escape_string($_POST['documento']);
  $correo    = $conn->real_escape_string($_POST['email']);
  $nivel     = (int) $_POST['nivel'];
  $pass      = $_POST['password'];

  // Verificar que no exista el correo
  $existe = $conn->query("SELECT 1 FROM usuarios WHERE correo = '$correo' LIMIT 1");
  if ($existe->num_rows) {
    $error = 'Ya existe una cuenta con ese correo.';
  } else {
    // Insertar en texto plano
    $sql = "INSERT INTO usuarios
                (nombre, apellido, documento, correo, contraseña, nivel)
                VALUES
                ('$nombre','$apellido','$documento','$correo','$pass',$nivel)";

    if ($conn->query($sql)) {
      // Auto-login tras registro
      $_SESSION['usuario_id'] = $conn->insert_id;
      $_SESSION['nivel']      = $nivel;

      // Registrar el movimiento en la tabla movimientos
      $campos_modif = 'nombre,apellido,documento,correo,contraseña,nivel';
      $valores_modif = "nulo,$nombre,nulo,$apellido,nulo,$documento,nulo,$correo,nulo,$pass,nulo,$nivel";
      $query = "INSERT INTO movimientos (usuario_id, tabla_modif, campos_modif, valores_modif, fecha)
                      VALUES (?, 'usuarios', ?, ?, NOW())";
      $stmtMov = $conn->prepare($query);
      $stmtMov->bind_param("iss", $_SESSION['usuario_id'], $campos_modif, $valores_modif);
      $stmtMov->execute();
      $stmtMov->close();
      header('Location: index.php');
      exit;
    } else {
      $error = 'Error al crear la cuenta: ' . $conn->error;
    }
  }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro - Biblioteca Mágica</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Tus estilos de login/registro -->
  <link rel="stylesheet" href="styles/login.css">
</head>

<body class="d-flex flex-column min-vh-100">
  <!-- Mensaje de error -->
  <?php if ($error): ?>
    <div class="container mt-4">
      <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
    </div>
  <?php endif; ?>

  <!-- Formulario de registro -->
  <div class="container py-5 flex-grow-1">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
          <div class="card-header bg-green text-white text-center py-3">
            <h2 class="fs-3 fw-bold mb-0">Crear Cuenta</h2>
          </div>
          <div class="card-body p-4">
            <form method="POST" action="registro.php">
              <div class="mb-3">
                <label class="form-label fw-medium">Nombre</label>
                <input type="text" name="nombre" class="form-control border-0 bg-light" required>
              </div>
              <div class="mb-3">
                <label class="form-label fw-medium">Apellido</label>
                <input type="text" name="apellido" class="form-control border-0 bg-light" required>
              </div>
              <div class="mb-3">
                <label class="form-label fw-medium">Documento (DNI)</label>
                <input type="text" name="documento" class="form-control border-0 bg-light" required>
              </div>
              <div class="mb-3">
                <label class="form-label fw-medium">Correo Electrónico</label>
                <input type="email" name="email" class="form-control border-0 bg-light" required>
              </div>
              <div class="mb-3">
                <label class="form-label fw-medium">Contraseña</label>
                <input type="password" name="password" class="form-control border-0 bg-light" required>
              </div>
              <div class="mb-3">
                <label class="form-label fw-medium">Nivel de Usuario</label>
                <select name="nivel" class="form-select" required>
                  <option value="1">1 - Básico</option>
                  <option value="2">2 - Encargado</option>
                  <option value="3">3 - Administrador</option>
                </select>
              </div>
              <button type="submit" class="btn btn-green w-100 py-2 rounded-pill mb-3">Crear Cuenta</button>
              <div class="text-center">
                <a href="login.php" class="text-decoration-none">← Volver al login</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Pie de página -->
  <footer class="bg-purple-dark text-white py-4 mt-auto text-center">
    <p class="mb-0">Biblioteca Mágica — Jardín de Infantes "Pequeños Exploradores"</p>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>