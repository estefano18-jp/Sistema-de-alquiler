<?php
session_start();

// Si el usuario ya ha iniciado sesión, redirigir según su rol
if (isset($_SESSION['login']) && $_SESSION['login']['permitido']) {
    if ($_SESSION['login']['rol'] === 'administrador') {
        header('Location: views/include/dashboard.administrador.php');
    } elseif ($_SESSION['login']['rol'] === 'cliente') {
        header('Location: views/include/dashboard.cliente.php');
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Inicio Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .input-group {
            position: relative;
        }
        .input-group .eye-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form id="form-login" method="POST" action="index.php">
            <div class="mb-3">
                <label for="inputEmail" class="form-label">Usuario:</label>
                <input type="text" id="inputEmail" name="nomuser" class="form-control" placeholder="Usuario" required>
            </div>
            <div class="mb-3">
                <label for="inputPassword" class="form-label">Contraseña:</label>
                <div class="input-group">
                    <input type="password" id="inputPassword" name="passuser" class="form-control" placeholder="Contraseña" required>
                    <i class="bi bi-eye eye-icon" id="togglePassword"></i>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
        </form>

        <div class="footer mt-3">
            <a href="./views/register.php" class="btn btn-link">Registrar Nuevo Usuario</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelector("#form-login").addEventListener("submit", (event) => {
                event.preventDefault();

                const params = new URLSearchParams();
                params.append("operation", "login");
                params.append("nomuser", document.querySelector("#inputEmail").value);
                params.append("passuser", document.querySelector("#inputPassword").value);

                fetch(`./controllers/usuario.controller.php?${params}`)
                    .then(response => response.json())
                    .then(acceso => {
                        if (!acceso.permitido) {
                            alert(acceso.status);
                        } else {
                            // Redirigir según el rol del usuario
                            if (acceso.rol === 'administrador') {
                                window.location.href = './views/include/dashboard.administrador.php';
                            } else if (acceso.rol === 'cliente') {
                                window.location.href = './views/include/dashboard.cliente.php';
                            }
                        }
                    });
            });

            // Mostrar y ocultar contraseña
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('inputPassword');

            togglePassword.addEventListener('click', () => {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                togglePassword.classList.toggle('bi-eye-slash');
            });
        });
    </script>
</body>
</html>
