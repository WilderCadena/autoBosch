<?php
// Conectar a la base de datos
include 'conexion.php';

// Obtener datos del formulario
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT); // Hashing de la contraseña

// Insertar en la base de datos
$sql = "INSERT INTO usuarios (nombres, apellidos, correo, telefono, contraseña) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $nombres, $apellidos, $correo, $telefono, $contraseña);

if ($stmt->execute()) {
    echo "Registro exitoso.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
