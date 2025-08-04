<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../Modelo/db.php';
include '../Modelo/enviar_correo.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $comentarios = $_POST['comentarios'];
    $imagen = null;

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['foto']['tmp_name'];
        $fileName = basename($_FILES['foto']['name']);
        $filePath = 'subidas/' . $fileName;
        move_uploaded_file($fileTmpPath, $filePath);
        $imagen = $filePath;
    }

    try {
        $stmt = $conexion->prepare("INSERT INTO cotizaciones (nombre, correo, comentario, imagen) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$nombre, $correo, $comentarios, $imagen])) {
            enviarCorreoCotizacion($correo, $nombre, $comentarios, 'wildercadena0828@gmail.com', $imagen);
            header("Location: cotizacion.php?enviado=ok");
            exit();
        }
    } catch (PDOException $e) {
        $mensaje = "Error al guardar la cotización: " . $e->getMessage();
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
    />
    <title>Realiza tu cotización</title>
</head>
<body class="bg-dark">

<!-- Navbar -->
<nav class="navbar navbar-dark bg-dark px-4">
    <a class="navbar-brand mb-0 h1 text-white text-decoration-none" href="../Vista/inicio.html">AutoBosch</a>
    <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
</nav>


<?php if (isset($_GET['enviado']) && $_GET['enviado'] === 'ok'): ?>
    <div class="container mt-5">
        <div class="alert alert-success text-center" role="alert">
            ✅ ¡Tu cotización fue enviada correctamente!
        </div>
    </div>
<?php else: ?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="bg-white p-4 rounded-5 text-secondary shadow" style="width: 25rem;">
        <h1 class="text-center fs-2 fw-bold">Realiza tu cotización</h1>

        <?php if (!empty($mensaje)): ?>
            <p class="text-danger text-center"><?= $mensaje ?></p>
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
    </div>
</div>

<?php endif; ?>

</body>
</html>
