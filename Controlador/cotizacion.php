<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../Modelo/db.php';
include '../Modelo/enviar_correo.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vehiculo    = trim($_POST['vehiculo'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $imagen      = null;

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['imagen']['tmp_name'];
        $fileName = basename($_FILES['imagen']['name']);
        $filePath = 'subidas/' . $fileName;
        move_uploaded_file($fileTmpPath, $filePath);
        $imagen = $filePath;
    }

    try {
        // Insertar cotización sin user_id
        $stmt = $conexion->prepare("INSERT INTO cotizaciones (nombre, correo, comentario, imagen) VALUES (?, ?, ?, ?)");

        $stmtUser = $conexion->prepare("SELECT Correo, Nombres FROM registro WHERE Id = ?");
        $stmtUser->execute([$_SESSION['user_id']]);
        $usuario = $stmtUser->fetch(PDO::FETCH_ASSOC);

        if ($stmt->execute([$usuario['Nombres'], $usuario['Correo'], $descripcion, $imagen])) {
            enviarCorreoCotizacion(
                $usuario['Correo'], 
                $usuario['Nombres'], 
                $descripcion, 
                'wildercadena0828@gmail.com', 
                $imagen
            );
            header("Location: cotizacion.php?enviado=ok");
            exit();
        }
    } catch (PDOException $e) {
        $mensaje = "❌ Error al guardar la cotización: " . $e->getMessage();
    }
}

$stmt = $conexion->prepare("SELECT * FROM registro WHERE Id = ?");
$stmt->execute([$_SESSION['user_id']]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Solicitud de Cotización - AutoBosch</title>
<link rel="stylesheet" href="../Vista/estilos.css">
</head>
<body>

<div class="form-container">
    <h2>Solicitar Cotización</h2>

    <p>Bienvenido, <?= htmlspecialchars($usuario['Nombres']) ?></p>

    <?php if (isset($_GET['enviado']) && $_GET['enviado'] === 'ok'): ?>
        <div class="alert-success-container">
            ✅ ¡Tu cotización fue enviada correctamente!
        </div>
        <div style="text-align:center; margin-top: 20px;">
            <a href="../Vista/inicio.html" class="btn-primary">Volver al inicio</a>
        </div>
    <?php else: ?>
        <?php if (!empty($mensaje)): ?>
            <div class="alert-danger">
                <?= htmlspecialchars($mensaje) ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <label for="vehiculo">Tipo de vehículo:</label>
            <input type="text" name="vehiculo" id="vehiculo" required>

            <label for="descripcion">Descripción del servicio:</label>
            <textarea name="descripcion" id="descripcion" rows="4" required></textarea>

            <label for="imagen">Adjuntar imagen (opcional):</label>
            <input type="file" name="imagen" id="imagen" accept="image/*">

            <button type="submit">Enviar Cotización</button>
        </form>
    <?php endif; ?>

    <a href="logout.php" class="btn-logout">Cerrar sesión</a>
</div>

</body>
</html>
