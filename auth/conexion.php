<?php
$servername = "localhost"; // Cambia esto si tu servidor es diferente
$username = "tu_usuario";   // Reemplaza 'tu_usuario' con tu nombre de usuario de la base de datos
$password = "tu_contraseña"; // Reemplaza 'tu_contraseña' con tu contraseña de la base de datos
$dbname = "autoserviciobosch"; // Asegúrate de que este sea el nombre correcto de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
