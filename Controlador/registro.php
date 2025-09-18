<?php
include '../Modelo/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);
    $password = $_POST['password'];

    // VALIDACIONES PHP
    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u", $nombres)) {
        $error = "⚠️ El nombre solo puede contener letras y espacios.";
    } elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u", $apellidos)) {
        $error = "⚠️ Los apellidos solo pueden contener letras y espacios.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL) || !str_contains($correo, '@')) {
        $error = "⚠️ Correo inválido.";
    } elseif (!preg_match("/^[0-9]+$/", $telefono) || (int)$telefono <= 0) {
        $error = "⚠️ El teléfono solo puede contener números positivos.";
    } else {
        // VALIDAR SI EL CORREO EXISTE
        $stmtCheck = $conexion->prepare("SELECT COUNT(*) FROM registro WHERE Correo = ?");
        $stmtCheck->execute([$correo]);
        if ($stmtCheck->fetchColumn() > 0) {
            $error = "⚠️ El correo ya está registrado.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmtRegistro = $conexion->prepare("INSERT INTO registro (Nombres, Apellidos, Correo, Telefono, Contraseña) VALUES (?, ?, ?, ?, ?)");
            if ($stmtRegistro->execute([$nombres, $apellidos, $correo, $telefono, $hash])) {
                header("Location: login.php?registro=success");
                exit();
            } else {
                $error = "❌ Error al registrar. Inténtalo de nuevo.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../Vista/estilos.css">
<title>Registro</title>
</head>
<body>

<div class="register-container">
    <h2>Registro de Usuario</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" id="formRegistro">
        <label for="nombres">Nombres:</label>
        <input type="text" id="nombres" name="nombres" required
               pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+"
               title="Solo letras y espacios">

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" required
               pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+"
               title="Solo letras y espacios">

        <label for="correo">Correo electrónico:</label>
        <input type="email" id="correo" name="correo" required placeholder="ejemplo@correo.com">

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" required placeholder="">

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" class="btn-submit">Registrarse</button>
    </form>

    <div class="form-footer">
        ¿Ya tienes cuenta? <a href="login.php">Iniciar sesión</a>
    </div>
</div>

<script>
    // Bloquear números en Nombres y Apellidos
    const soloLetras = (e) => {
        const char = String.fromCharCode(e.keyCode);
        if (!/[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/.test(char) && e.keyCode !== 8 && e.keyCode !== 32) {
            e.preventDefault();
        }
    }

    document.getElementById('nombres').addEventListener('keypress', soloLetras);
    document.getElementById('apellidos').addEventListener('keypress', soloLetras);

    // Bloquear letras en Teléfono, solo números positivos
    document.getElementById('telefono').addEventListener('keypress', function(e) {
        const char = String.fromCharCode(e.keyCode);
        if (!/[0-9]/.test(char)) {
            e.preventDefault();
        }
    });
</script>

</body>
</html>
