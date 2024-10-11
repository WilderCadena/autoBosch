<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php'); // Redirigir a la página de inicio de sesión
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Cotización</title>
    <link rel="stylesheet" href="../Estilos/estilos.css">
</head>
<body>
    <h1>Enviar Cotización</h1>
    <form action="guardar_cotizacion.php" method="POST" enctype="multipart/form-data">
        <textarea name="comentario" placeholder="Describe la falla" required></textarea>
        
        <label for="imagenes">Selecciona hasta 10 imágenes:</label>
        <input type="file" name="imagenes[]" multiple required>
        
        <button type="submit">Enviar Cotización</button>
    </form>
</body>
</html>
