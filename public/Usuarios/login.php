<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once app_path('public/conex.php');
// login.php
session_start();

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
                header('Location: ' . app_path('public\ABM\ABM_index.php'));
            } else {
                header('Location: ' . app_path('public/index.php'));
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
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Mágica - Iniciar Sesión</title>

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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .container {
            width: 100%;
            max-width: 28rem;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-section {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .logo-icon {
            background: linear-gradient(135deg, #26a69a, #00acc1);
            padding: 1rem;
            border-radius: 1.5rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .logo-icon i {
            color: white;
            font-size: 2rem;
        }

        .header h1 {
            font-size: 2rem;
            font-weight: bold;
            color: #00695c;
            margin-bottom: 0.5rem;
        }

        .header p {
            color: #26a69a;
            font-size: 1rem;
        }

        /* Auth Card */
        .auth-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border-radius: 1.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid #b2dfdb;
            overflow: hidden;
        }

        /* Tabs */
        .tabs {
            display: flex;
            background: #f0f9ff;
            margin: 1.5rem 1.5rem 0;
            border-radius: 1rem;
            padding: 0.25rem;
        }

        .tab-button {
            flex: 1;
            padding: 0.75rem 1rem;
            background: transparent;
            border: none;
            border-radius: 0.75rem;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            color: #26a69a;
            font-size: 0.9rem;
        }

        .tab-button.active {
            background: white;
            color: #00695c;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px);
        }

        .tab-button:hover:not(.active) {
            background: rgba(255, 255, 255, 0.5);
        }

        /* Tab Content */
        .tab-content {
            display: none;
            padding: 1.5rem;
        }

        .tab-content.active {
            display: block;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #00695c;
            font-size: 0.9rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #26a69a;
            font-size: 1.1rem;
        }

        .form-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #b2dfdb;
            border-radius: 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
        }

        .form-input.with-icon {
            padding-left: 2.75rem;
        }

        .form-input.with-toggle {
            padding-right: 2.75rem;
        }

        .form-input:focus {
            outline: none;
            border-color: #26a69a;
            box-shadow: 0 0 0 3px rgba(38, 166, 154, 0.1);
            background: white;
        }

        .form-input::placeholder {
            color: #9ca3af;
        }

        /* Password Toggle */
        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #26a69a;
            padding: 0.25rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }

        .password-toggle:hover {
            background: rgba(38, 166, 154, 0.1);
            color: #00695c;
        }

        /* Select */
        .select-wrapper {
            position: relative;
        }

        .form-select {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #b2dfdb;
            border-radius: 1rem;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.8);
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2326a69a' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 1rem center;
            background-repeat: no-repeat;
            background-size: 1rem;
            padding-right: 2.75rem;
            transition: all 0.3s ease;
        }

        .form-select:focus {
            outline: none;
            border-color: #26a69a;
            box-shadow: 0 0 0 3px rgba(38, 166, 154, 0.1);
            background-color: white;
        }

        /* Buttons */
        .submit-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #26a69a, #00acc1);
            color: white;
            border: none;
            border-radius: 1rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, #00897b, #0097a7);
            transform: translateY(-2px);
            box-shadow: 0 8px 15px -3px rgba(0, 0, 0, 0.2);
        }

        .back-btn {
            width: 100%;
            padding: 1rem;
            background: #78909c;
            color: white;
            border: none;
            border-radius: 1rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 0.75rem;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .back-btn:hover {
            background: #607d8b;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px -3px rgba(0, 0, 0, 0.2);
        }

        /* Forgot Password */
        .forgot-password {
            text-align: center;
            margin-top: 1rem;
        }

        .forgot-password a {
            color: #26a69a;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .forgot-password a:hover {
            color: #00695c;
            text-decoration: underline;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 1.5rem;
            color: #26a69a;
            font-size: 0.875rem;
        }

        /* Alert Error */
        .alert-error {
            width: 100%;
            max-width: 28rem;
            margin: 0 auto 1rem;
            padding: 1rem;
            background: rgba(254, 226, 226, 0.9);
            color: #dc2626;
            border: 2px solid #fca5a5;
            border-radius: 1rem;
            text-align: center;
            font-weight: 500;
            backdrop-filter: blur(8px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Floating Elements */
        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .shape-1 {
            width: 80px;
            height: 80px;
            background: #26a69a;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 60px;
            height: 60px;
            background: #00acc1;
            top: 20%;
            right: 15%;
            animation-delay: 2s;
        }

        .shape-3 {
            width: 100px;
            height: 100px;
            background: #4db6ac;
            bottom: 15%;
            left: 20%;
            animation-delay: 4s;
        }

        .shape-4 {
            width: 70px;
            height: 70px;
            background: #80cbc4;
            bottom: 25%;
            right: 10%;
            animation-delay: 1s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        /* Responsive */
        @media (max-width: 640px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .container {
                padding: 0 0.5rem;
            }

            .header h1 {
                font-size: 1.75rem;
            }

            .tab-button {
                font-size: 0.8rem;
                padding: 0.625rem 0.75rem;
            }
        }

        @media (max-width: 480px) {
            .auth-card {
                margin: 0.5rem;
            }

            .tab-content {
                padding: 1rem;
            }

            .tabs {
                margin: 1rem 1rem 0;
            }
        }
    </style>
</head>

<body>
    <!-- Floating Shapes -->
    <div class="floating-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="shape shape-4"></div>
    </div>

    <?php if ($error): ?>
        <div class="alert-error">
            <i class="fas fa-exclamation-triangle" style="margin-right: 0.5rem;"></i>
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo-section">
                <div class="logo-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div>
                    <h1>Biblioteca Mágica</h1>
                    <p>Accede a tu mundo de conocimiento</p>
                </div>
            </div>
        </div>

        <!-- Auth Card -->
        <div class="auth-card">
            <!-- Login Form -->
            <div id="login-tab" class="tab-content <?= $showTab === 'login' ? 'active' : '' ?>">
                <form method="POST" action="<?= app_path('public/Usuarios/login.php') ?>">
                    <input type="hidden" name="action_type" value="login">

                    <div class="form-group">
                        <label for="login-email">
                            <i class="fas fa-envelope" style="margin-right: 0.5rem;"></i>
                            Correo electrónico
                        </label>
                        <div class="input-wrapper">
                            <i class="fas fa-at input-icon"></i>
                            <input type="email" id="login-email" name="login_email" class="form-input with-icon" placeholder="tu@email.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="login-password">
                            <i class="fas fa-lock" style="margin-right: 0.5rem;"></i>
                            Contraseña
                        </label>
                        <div class="input-wrapper">
                            <i class="fas fa-key input-icon"></i>
                            <input type="password" id="login-password" name="login_password" class="form-input with-icon with-toggle" placeholder="••••••••" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('login-password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn">
                        <i class="fas fa-sign-in-alt" style="margin-right: 0.5rem;"></i>
                        Iniciar Sesión
                    </button>

                    <div class="forgot-password">
                        <a href="#" onclick="alert('Funcionalidad de recuperación de contraseña próximamente')">
                            <i class="fas fa-question-circle" style="margin-right: 0.25rem;"></i>
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>
                </form>
            </div>

            <!-- Back Button -->
            <div style="padding: 0 1.5rem 1.5rem;">
                <a href="index.php" class="back-btn">
                    <i class="fas fa-arrow-left" style="margin-right: 0.5rem;"></i>
                    Volver al Inicio
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>
                <i class="fas fa-shield-alt" style="margin-right: 0.25rem;"></i>
                Al continuar, aceptas nuestros términos y condiciones
            </p>
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
            const icon = button.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'fas fa-eye';
            }
        }

        // Validación en tiempo real para el DNI
        document.getElementById('document')?.addEventListener('input', function(e) {
            const value = e.target.value;
            // Solo permitir números
            e.target.value = value.replace(/[^0-9]/g, '');
        });

        // Animación de entrada
        document.addEventListener('DOMContentLoaded', function() {
            const authCard = document.querySelector('.auth-card');
            const header = document.querySelector('.header');

            authCard.style.opacity = '0';
            authCard.style.transform = 'translateY(20px)';
            header.style.opacity = '0';
            header.style.transform = 'translateY(-20px)';

            setTimeout(() => {
                header.style.transition = 'all 0.6s ease';
                header.style.opacity = '1';
                header.style.transform = 'translateY(0)';
            }, 100);

            setTimeout(() => {
                authCard.style.transition = 'all 0.6s ease';
                authCard.style.opacity = '1';
                authCard.style.transform = 'translateY(0)';
            }, 300);
        });

        // Efecto de focus mejorado
        document.querySelectorAll('.form-input, .form-select').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>

</html>