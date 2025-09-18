<?php
// Controlador/reset_password.php

session_start();
include '../Modelo/db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../Libs/PHPMailer-master/src/PHPMailer.php';
require '../Libs/PHPMailer-master/src/SMTP.php';
require '../Libs/PHPMailer-master/src/Exception.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$mensaje = '';
$error = false;

// Obtener token de la URL
$token = $_GET['token'] ?? '';

if (empty($token)) {
    die("❌ Token no válido.");
}

// Buscar usuario con el token
$stmt = $conexion->prepare("SELECT * FROM registro WHERE reset_token = ?");
$stmt->execute([$token]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    die("❌ Token inválido o expirado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nueva_contrasena = $_POST['password'] ?? '';
    $confirmar_contrasena = $_POST['confirm_password'] ?? '';

    if (empty($nueva_contrasena) || empty($confirmar_contrasena)) {
        $mensaje = "❌ Ambos campos son obligatorios.";
        $error = true;
    } elseif ($nueva_contrasena !== $confirmar_contrasena) {
        $mensaje = "❌ Las contraseñas no coinciden.";
        $error = true;
    } else {
        $hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
        $update = $conexion->prepare("UPDATE registro SET Contraseña = ?, reset_token = NULL WHERE Id = ?");
        if ($update->execute([$hash, $usuario['Id']])) {
            // Redirigir al login con mensaje de éxito
            header("Location: login.php?mensaje=contraseña_actualizada");
            exit();
        } else {
            $mensaje = "❌ Error al actualizar la contraseña.";
            $error = true;
        }
    }
}
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

<div class="form-container">
    <h2>Restablecer contraseña</h2>

    <?php if (!empty($mensaje)): ?>
        <div class="<?= $error ? 'alert-danger' : 'alert-success-container' ?>">
            <?= htmlspecialchars($mensaje) ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <label for="password">Nueva contraseña:</label>
        <input type="password" name="password" id="password" required>

        <label for="confirm_password">Confirmar contraseña:</label>
        <input type="password" name="confirm_password" id="confirm_password" required>

        <button type="submit">Restablecer contraseña</button>
    </form>
</div>

</body>
</html>
