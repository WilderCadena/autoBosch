<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotización</title>
    <link rel="stylesheet" href="../Estilos/estilos.css"> <!-- Asegúrate de que la ruta sea correcta -->
</head>
<body>
    <h1>Enviar Cotización</h1>
    <form action="guardar_cotizacion.php" method="POST" enctype="multipart/form-data">
        <textarea name="comentario" placeholder="Describe la falla" required></textarea>
        <input type="file" name="imagen" required>
        <button type="submit">Enviar Cotización</button>
    </form>
</body>
</html>
