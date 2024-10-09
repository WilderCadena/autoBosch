<?php
// Conectar a la base de datos
include 'conexion.php';

// Obtener datos del formulario
$correo = $_POST['correo'];
$contraseña = $_POST['contraseña'];

// Buscar el usuario en la base de datos
$sql = "SELECT * FROM usuarios WHERE correo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
    // Verificar la contraseña
    if (password_verify($contraseña, $usuario['contraseña'])) {
        session_start();
        $_SESSION['usuario_id'] = $usuario['id']; // Guardar el ID del usuario en la sesión
        echo "Bienvenido, " . $usuario['nombres'];
        // Aquí redirigir a la página de cotización
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "Usuario no encontrado.";
}

$stmt->close();
$conn->close();
?>
