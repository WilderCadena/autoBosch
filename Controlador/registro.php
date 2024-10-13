<?php

include '../Modelo/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $contrasena = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    $stmtRegistro = $conexion->prepare("INSERT INTO registro (Nombres, Apellidos, Correo, Telefono, Contraseña) VALUES (?, ?, ?, ?, ?)");

    
    if ($stmtRegistro->execute([$nombres, $apellidos, $correo, $telefono, $contrasena])) {
        echo "Registro exitoso.";
    } else {
        echo "Error al registrar.";
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
    <title>Registro</title>
</head>
<body class="bg-dark d-flex justify-content-center align-items-center vh-100">
    <div class="bg-white p-5 rounded-5 text-secondary shadow" style="width: 25rem;">
        <div class="text-center fs-1 fw-bold">Registrarse</div>
        <form method="post">
            <div class="input-group mt-4">
                <input type="text" name="nombres" class="form-control bg-light" placeholder="Nombres" required>
            </div>
            <div class="input-group mt-1">
                <input type="text" name="apellidos" class="form-control bg-light" placeholder="Apellidos" required>
            </div>
            <div class="input-group mt-1">
                <input type="email" name="correo" class="form-control bg-light" placeholder="Correo" required>
            </div>
            <div class="input-group mt-1">
                <input type="tel" name="telefono" class="form-control bg-light" placeholder="Teléfono" required>
            </div>
            <div class="input-group mt-1">
                <input type="password" name="password" class="form-control bg-light" placeholder="Contraseña" required>
            </div>
            <div class="d-flex justify-content-center mt-4">
                <button type="submit" class="btn" style="background-color: #1abc9c; color: white; width: 100%; font-weight: 600;">Registrarse</button>
            </div>
        </form>
        <div class="d-flex gap-1 justify-content-center mt-3">
            <div>¿Ya tienes cuenta?</div>
            <a href="login.php" class="text-decoration-none" style="color: #1abc9c; font-weight: 600;">Iniciar sesión</a>
        </div>
    </div>
</body>
</html>






    