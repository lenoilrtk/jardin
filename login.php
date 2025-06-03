<?php
// login.php
session_start();
include 'ABM/conex.php';  // Conexión a BDD

$error = '';
$showTab = 'login'; // Por defecto mostrar pestaña de login

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_type']) && $_POST['action_type'] === 'login') {
    $correo = $conn->real_escape_string($_POST['login_email']);
    $pass   = $_POST['login_password'];

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
            $showTab = 'login';
        }
    } else {
        $error = 'No existe una cuenta con ese correo.';
        $showTab = 'login';
    }
}

// Si por GET se indica ?tab=signup, mostramos la pestaña de registro
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['tab']) && $_GET['tab'] === 'signup') {
    $showTab = 'signup';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Biblioteca Mágica - Autenticación</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #fce7f3 0%, #f3e8ff 50%, #e0e7ff 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .container {
      width: 100%;
      max-width: 450px;
    }

    .header {
      text-align: center;
      margin-bottom: 2rem;
    }

    .header-icon {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 1rem;
    }

    .book-icon {
      width: 32px;
      height: 32px;
      color: #ec4899;
    }

    .header h1 {
      font-size: 2rem;
      font-weight: bold;
      background: linear-gradient(135deg, #ec4899, #8b5cf6);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin-bottom: 0.5rem;
    }

    .header p {
      color: #6b7280;
      font-size: 1rem;
    }

    .auth-card {
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(10px);
      border-radius: 16px;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
      overflow: hidden;
    }

    .tabs {
      display: flex;
      background: #f3f4f6;
      margin: 1.5rem 1.5rem 0;
      border-radius: 8px;
      padding: 4px;
    }

    .tab-button {
      flex: 1;
      padding: 12px;
      background: transparent;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-weight: 500;
      transition: all 0.2s;
      color: #6b7280;
    }

    .tab-button.active {
      background: white;
      color: #111827;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .tab-content {
      display: none;
      padding: 1.5rem;
    }

    .tab-content.active {
      display: block;
    }

    .form-group {
      margin-bottom: 1rem;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1rem;
      margin-bottom: 1rem;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 500;
      color: #374151;
      font-size: 0.875rem;
    }

    .input-wrapper {
      position: relative;
    }

    .input-icon {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      width: 16px;
      height: 16px;
      color: #9ca3af;
    }

    .form-input {
      width: 100%;
      padding: 12px 16px;
      border: 1px solid #d1d5db;
      border-radius: 8px;
      font-size: 1rem;
      transition: all 0.2s;
      background: white;
    }

    .form-input.with-icon {
      padding-left: 40px;
    }

    .form-input.with-toggle {
      padding-right: 40px;
    }

    .form-input:focus {
      outline: none;
      border-color: #ec4899;
      box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
    }

    .password-toggle {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
      color: #9ca3af;
      padding: 4px;
    }

    .password-toggle:hover {
      color: #6b7280;
    }

    .select-wrapper {
      position: relative;
    }

    .form-select {
      width: 100%;
      padding: 12px 16px;
      border: 1px solid #d1d5db;
      border-radius: 8px;
      font-size: 1rem;
      background: white;
      cursor: pointer;
      appearance: none;
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
      background-position: right 12px center;
      background-repeat: no-repeat;
      background-size: 16px;
      padding-right: 40px;
    }

    .form-select:focus {
      outline: none;
      border-color: #ec4899;
      box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
    }

    .submit-btn {
      width: 100%;
      padding: 12px;
      background: linear-gradient(135deg, #ec4899, #8b5cf6);
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s;
      margin-top: 1rem;
    }

    .submit-btn:hover {
      background: linear-gradient(135deg, #db2777, #7c3aed);
      transform: translateY(-1px);
    }

    .back-btn {
      width: 100%;
      padding: 12px;
      background: #6b7280;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s;
      margin-top: 0.5rem;
      text-decoration: none;
      display: inline-block;
      text-align: center;
    }

    .back-btn:hover {
      background: #4b5563;
      transform: translateY(-1px);
    }

    .forgot-password {
      text-align: center;
      margin-top: 1rem;
    }

    .forgot-password a {
      color: #6b7280;
      text-decoration: underline;
      font-size: 0.875rem;
    }

    .forgot-password a:hover {
      color: #374151;
    }

    .footer {
      text-align: center;
      margin-top: 1.5rem;
      color: #6b7280;
      font-size: 0.875rem;
    }

    .alert-error {
      width: 100%;
      max-width: 450px;
      margin: 10px auto;
      padding: 12px;
      background: #fee2e2;
      color: #b91c1c;
      border: 1px solid #fca5a5;
      border-radius: 8px;
      text-align: center;
    }

    @media (max-width: 480px) {
      .form-row {
        grid-template-columns: 1fr;
      }

      .container {
        padding: 0 10px;
      }
    }
  </style>
</head>
<body>
  <?php if ($error): ?>
    <div class="alert-error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <div class="container">
    <!-- Header -->
    <div class="header">
      <div class="header-icon">
        <svg class="book-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
          </path>
        </svg>
        <h1>Biblioteca Mágica</h1>
      </div>
      <p>Accede a tu mundo de conocimiento</p>
    </div>

    <!-- Auth Card -->
    <div class="auth-card">
      <!-- Tabs -->
      <div class="tabs">
        <button class="tab-button <?= $showTab === 'login' ? 'active' : '' ?>" onclick="switchTab(event, 'login')">Iniciar Sesión</button>
        <button class="tab-button <?= $showTab === 'signup' ? 'active' : '' ?>" onclick="switchTab(event, 'signup')">Crear Cuenta</button>
      </div>

      <!-- Login Form -->
      <div id="login-tab" class="tab-content <?= $showTab === 'login' ? 'active' : '' ?>">
        <form method="POST" action="login.php">
          <input type="hidden" name="action_type" value="login">
          <div class="form-group">
            <label for="login-email">Correo electrónico</label>
            <div class="input-wrapper">
              <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                </path>
              </svg>
              <input type="email" id="login-email" name="login_email" class="form-input with-icon" placeholder="tu@email.com" required>
            </div>
          </div>

          <div class="form-group">
            <label for="login-password">Contraseña</label>
            <div class="input-wrapper">
              <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                </path>
              </svg>
              <input type="password" id="login-password" name="login_password" class="form-input with-icon with-toggle" placeholder="••••••••" required>
              <button type="button" class="password-toggle" onclick="togglePassword('login-password')">
                <svg class="eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                  </path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                  </path>
                </svg>
              </button>
            </div>
          </div>

          <button type="submit" class="submit-btn">Iniciar Sesión</button>

          <div class="forgot-password">
            <a href="#" onclick="alert('Funcionalidad de recuperación de contraseña')">¿Olvidaste tu contraseña?</a>
          </div>
        </form>
      </div>

      <!-- Signup Form -->
      <div id="signup-tab" class="tab-content <?= $showTab === 'signup' ? 'active' : '' ?>">
        <form method="POST" action="registro.php">
          <div class="form-row">
            <div class="form-group">
              <label for="first-name">Nombre</label>
              <div class="input-wrapper">
                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                  </path>
                </svg>
                <input type="text" id="first-name" name="nombre" class="form-input with-icon" placeholder="Juan" required>
              </div>
            </div>

            <div class="form-group">
              <label for="last-name">Apellido</label>
              <input type="text" id="last-name" name="apellido" class="form-input" placeholder="Pérez" required>
            </div>
          </div>

          <div class="form-group">
            <label for="document">Documento (DNI)</label>
            <div class="input-wrapper">
              <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2">
                </path>
              </svg>
              <input type="text" id="document" name="documento" class="form-input with-icon" placeholder="12345678" pattern="[0-9]{8,10}" required>
            </div>
          </div>

          <div class="form-group">
            <label for="signup-email">Correo electrónico</label>
            <div class="input-wrapper">
              <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                </path>
              </svg>
              <input type="email" id="signup-email" name="email" class="form-input with-icon" placeholder="tu@email.com" required>
            </div>
          </div>

          <div class="form-group">
            <label for="signup-password">Contraseña</label>
            <div class="input-wrapper">
              <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                </path>
              </svg>
              <input type="password" id="signup-password" name="password" class="form-input with-icon with-toggle" placeholder="••••••••" required>
              <button type="button" class="password-toggle" onclick="togglePassword('signup-password')">
                <svg class="eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                  </path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                  </path>
                </svg>
              </button>
            </div>
          </div>

          <div class="form-group">
            <label for="user-level">Nivel de Usuario</label>
            <div class="select-wrapper">
              <select id="user-level" name="nivel" class="form-select" required>
                <option value="">Selecciona un nivel</option>
                <option value="1">1 - Básico</option>
                <option value="2">2 - Encargado</option>
                <option value="3">3 - Administrador</option>
              </select>
            </div>
          </div>

          <button type="submit" class="submit-btn">Crear Cuenta</button>
        </form>
      </div>

      <!-- Back Button -->
      <div style="padding: 0 1.5rem 1.5rem;">
        <a href="index.php" class="back-btn">← Volver al Inicio</a>
      </div>
    </div>

    <!-- Footer -->
    <div class="footer">
      <p>Al continuar, aceptas nuestros términos y condiciones</p>
    </div>
  </div>

  <script>
    function switchTab(event, tabName) {
      // Hide all tab contents
      const tabContents = document.querySelectorAll('.tab-content');
      tabContents.forEach(content => content.classList.remove('active'));

      // Remove active class from all tab buttons
      const tabButtons = document.querySelectorAll('.tab-button');
      tabButtons.forEach(button => button.classList.remove('active'));

      // Show selected tab content
      document.getElementById(tabName + '-tab').classList.add('active');

      // Add active class to clicked button
      event.currentTarget.classList.add('active');
    }

    function togglePassword(inputId) {
      const input = document.getElementById(inputId);
      const button = input.nextElementSibling;
      const eyeIcon = button.querySelector('.eye-icon');

      if (input.type === 'password') {
        input.type = 'text';
        eyeIcon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21">
          </path>
        `;
      } else {
        input.type = 'password';
        eyeIcon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
          </path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
          </path>
        `;
      }
    }

    // Validación en tiempo real para el DNI
    document.getElementById('document')?.addEventListener('input', function(e) {
      const value = e.target.value;
      // Solo permitir números
      e.target.value = value.replace(/[^0-9]/g, '');
    });
  </script>
</body>
</html>
