<?php
session_start();
include '../Modelo/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $contrasena = $_POST['password'];

    $stmtLogin = $conexion->prepare("SELECT * FROM registro WHERE Correo = ?");
    $stmtLogin->execute([$correo]);
    $usuario = $stmtLogin->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($contrasena, $usuario['Contraseña'])) {
        $_SESSION['user_id'] = $usuario['Id'];
        header("Location: cotizacion.php");
        exit();
    } else {
        $error = "Correo o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="../Vista/estilos.css">
</head>
<body>

<div class="login-container">
    <h2>Iniciar sesión</h2>

    <?php if (isset($_GET['cerrado']) && $_GET['cerrado'] == 1): ?>
        <div class="alert alert-success">✅ Has cerrado sesión correctamente.</div>
    <?php endif; ?>

    <?php if (isset($_GET['registro']) && $_GET['registro'] === 'success'): ?>
        <div class="alert alert-success">✅ Registro exitoso. ¡Ahora puedes iniciar sesión!</div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'contraseña_actualizada'): ?>
    <div class="alert alert-success text-center">
        ✅ Tu contraseña ha sido cambiada satisfactoriamente. ¡Ahora puedes iniciar sesión!
    </div>
    <?php endif; ?>


    <form method="post">
        <label for="correo">Correo electrónico</label>
        <input type="email" name="correo" id="correo" placeholder="ejemplo@correo.com" required>

        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" placeholder="Contraseña" required>

        <button type="submit">Iniciar sesión</button>
    </form>

    <p class="olvide">
        ¿Olvidaste tu contraseña? <a href="recuperar.php">Haz clic aquí</a>
    </p>
    <div class="form-footer">
        ¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a>
    </div>
</div>

</body>
</html>
