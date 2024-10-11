<?php
session_start(); // Inicia la sesión

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php'); // Redirige a la página de inicio de sesión si no está autenticado
    exit();
}

// Procesar la cotización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $detalles = $_POST['detalles'];

    // Aquí puedes agregar la lógica para guardar la cotización en la base de datos
    // ...

    echo "Cotización enviada exitosamente. Nos pondremos en contacto contigo pronto.";
}
?>
