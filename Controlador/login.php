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
        $_SESSION['user_id'] = $usuario['id'];
        header("Location: cotizacion.php");
        exit();
    } else {
        echo "Correo o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx"
      crossorigin="anonymous"
    />
    <title>Iniciar sesión</title>
</head>
<body class="bg-dark d-flex justify-content-center align-items-center vh-100">
    <div class="bg-white p-5 rounded-5 text-secondary shadow" style="width: 25rem;">
        <div class="text-center fs-1 fw-bold">Iniciar sesión</div>
        <form method="post">
            <div class="input-group mt-4">
                <input type="email" name="correo" class="form-control bg-light" placeholder="Correo electrónico" required>
            </div>
            <div class="input-group mt-1">
                <input type="password" name="password" class="form-control bg-light" placeholder="Contraseña" required>
            </div>
            <div class="d-flex justify-content-center mt-4">
                <button type="submit" class="btn" style="background-color: #1abc9c; color: white; width: 100%; font-weight: 600;">Iniciar sesión</button>
            </div>
        </form>
        <div class="d-flex gap-1 justify-content-center mt-3">
            <div>¿No tienes cuenta?</div>
            <a href="registro.php" class="text-decoration-none" style="color: #1abc9c; font-weight: 600;">Regístrate aquí</a>
        </div>
    </div>
</body>
</html>

