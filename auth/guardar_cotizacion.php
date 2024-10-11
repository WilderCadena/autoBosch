<?php
// Conectar a la base de datos
include 'conexion.php';
session_start();

// Verificar que el usuario esté logueado
if (!isset($_SESSION['usuario_id'])) {
    die("Acceso no autorizado.");
}

// Obtener datos del formulario
$comentario = $_POST['comentario'];
$usuario_id = $_SESSION['usuario_id'];

// Manejo de la imagen
$imagen = $_FILES['imagen']['name'];
$target = "uploads/" . basename($imagen);
if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target)) {
    // Insertar en la base de datos
    $sql = "INSERT INTO cotizaciones (usuario_id, comentario, imagen) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$usuario_id, $comentario, $imagen])) {
        echo "Cotización enviada.";
    } else {
        echo "Error al enviar la cotización.";
    }
} else {
    echo "Error al subir la imagen.";
}
?>
