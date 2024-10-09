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
move_uploaded_file($_FILES['imagen']['tmp_name'], $target);

// Insertar en la base de datos
$sql = "INSERT INTO cotizaciones (usuario_id, comentario, imagen) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $usuario_id, $comentario, $imagen);

if ($stmt->execute()) {
    echo "Cotización enviada.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
