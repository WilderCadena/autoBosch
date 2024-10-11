<?php
session_start(); // Inicia la sesión
include 'conexion.php'; // Asegúrate de que la ruta sea correcta

// Verificar si se han enviado los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    // Preparar la consulta SQL para verificar el usuario
    $stmt = $pdo->prepare("SELECT * FROM registro WHERE Correo = :correo");
    $stmt->bindParam(':correo', $correo);
    $stmt->execute();

    // Verificar si se encontró el usuario
    if ($stmt->rowCount() > 0) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verificar la contraseña
        if (password_verify($contraseña, $usuario['Contraseña'])) {
            // Contraseña correcta: guardar la sesión y redirigir
            $_SESSION['usuario'] = $usuario['Nombres']; // Cambiar según lo que necesites
            header("Location: cotizacion.php");
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "No se encontró el usuario.";
    }
}
?>
