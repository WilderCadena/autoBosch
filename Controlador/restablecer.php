<?php
$correo = $_GET['correo'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer contraseña</title>
    <link rel="stylesheet" href="../Vista/estilos.css">
</head>
<body>

<div class="restablecer-container">
    <h2>Restablecer contraseña</h2>
    <form action="procesar_restablecer.php" method="POST">
        <input type="hidden" name="correo" value="<?= htmlspecialchars($correo) ?>">

        <label for="nueva">Nueva contraseña:</label>
        <input type="password" name="nueva" id="nueva" required>

        <label for="repite">Repite la contraseña:</label>
        <input type="password" name="repite" id="repite" required>

        <button type="submit">Guardar nueva contraseña</button>
    </form>
</div>

</body>
</html>
