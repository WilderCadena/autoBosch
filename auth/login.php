<?php
session_start(); // Inicia la sesión

// Incluir archivo de conexión a la base de datos
include '../auth/conexion.php'; // Asegúrate de que la ruta sea correcta

// Comprobar si se han enviado las credenciales
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener las credenciales del formulario
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    // Preparar la consulta para obtener el usuario
    $stmt = $pdo->prepare("SELECT * FROM registro WHERE Correo = ?"); // Cambiado a 'registro'
    $stmt->execute([$correo]);
    $usuario = $stmt->fetch();

    // Verificar si el usuario existe y la contraseña es correcta
    if ($usuario && password_verify($contraseña, $usuario['Contraseña'])) {
        $_SESSION['usuario'] = $correo; // Guarda el usuario en la sesión
        header('Location: ../auth/cotizacion.php'); // Redirige si es exitoso
        exit();
    } else {
        $error = "Credenciales incorrectas. Intenta de nuevo.";
    }
}

// Si el usuario ya está autenticado, no redirigimos y mostramos el formulario
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="iconocra.jpg">
    <link rel="stylesheet" href="../Estilos/estilos.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            max-width: 400px;
            margin: auto;
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
        }
        input[type="email"], input[type="password"] {
            padding: 8px;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <h2>Login</h2>
    <form action="" method="post">
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" required>

        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required>

        <input type="submit" value="Iniciar Sesión">
    </form>
    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <p>No estás registrado? <a href="registro.php">Regístrate aquí</a></p>

</body>
</html>
