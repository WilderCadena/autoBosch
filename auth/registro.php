<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="../Estilos/estilos.css"> <!-- Asegúrate de que la ruta sea correcta -->
</head>
<body>
    <h1>Registro</h1>
    <form action="guardar_registro.php" method="POST">
        <input type="text" name="nombres" placeholder="Nombres" required>
        <input type="text" name="apellidos" placeholder="Apellidos" required>
        <input type="email" name="correo" placeholder="Correo" required>
        <input type="text" name="telefono" placeholder="Teléfono" required>
        <input type="password" name="contraseña" placeholder="Contraseña" required>
        <button type="submit">Registrar</button>
    </form>
</body>
</html>
