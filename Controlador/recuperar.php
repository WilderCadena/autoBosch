<?php
// formulario para enviar el correo de recuperación
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>
    <link rel="stylesheet" href="../Vista/estilos.css">
</head>
<body>

<div class="recuperar-container">
    <h2>Recuperar contraseña</h2>
    <form action="enviar_recuperar.php" method="POST">
        <label for="Correo">Introduce tu correo electrónico:</label>
        <input type="email" name="Correo" id="Correo" placeholder="ejemplo@correo.com" required>
        <button type="submit">Enviar enlace de recuperación</button>
    </form>
</div>

</body>
</html>
