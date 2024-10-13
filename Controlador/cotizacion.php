<?php
include '../Modelo/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $comentarios = $_POST['comentarios'];
    $imagen = null;

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['foto']['tmp_name'];
        $fileName = $_FILES['foto']['name'];
        $filePath = 'subidas/' . $fileName; 

        move_uploaded_file($fileTmpPath, $filePath);
        $imagen = $filePath; // Guarda la ruta de la imagen
    }

    // Inserta los datos en la base de datos
    try {
        $stmt = $conexion->prepare("INSERT INTO cotizaciones (nombre, correo, comentario, imagen) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $correo, $comentarios, $imagen]);

        // Redirige a la misma página con un mensaje de éxito
        header("Location: cotizacion.php?mensaje=success");
        exit();
    } catch (PDOException $e) {
        echo "Error al guardar la cotización: " . $e->getMessage();
    }
}

// Verifica si hay un mensaje en la URL
$mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';
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
    <title>Realiza tu cotización</title>
</head>
<body class="bg-dark d-flex justify-content-center align-items-center vh-100">
    <div class="bg-white p-4 rounded-5 text-secondary shadow" style="width: 25rem;">
        <h1 class="text-center fs-2 fw-bold">Realiza tu cotización</h1>

        <?php if ($mensaje === 'success'): ?>
            <p class="text-success text-center">¡Cotización enviada con éxito!</p>
        <?php endif; ?>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">Correo electrónico:</label>
                <input type="email" id="correo" name="correo" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="comentarios" class="form-label">Comentarios:</label>
                <textarea id="comentarios" name="comentarios" class="form-control" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Adjuntar foto:</label>
                <input type="file" id="foto" name="foto" class="form-control" accept="image/*">
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn" style="background-color: #1abc9c; color: white;">Enviar cotización</button>
            </div>
        </form>

        <h2 class="mt-4 text-center">¿Deseas cerrar sesión?</h2>
        <form action="logout.php" method="post" class="text-center">
            <button type="submit" name="cerrar_sesion" value="si" class="btn btn-danger">Sí</button>
            <button type="submit" name="cerrar_sesion" value="no" class="btn btn-secondary">No</button>
        </form>
    </div>
</body>
</html>
