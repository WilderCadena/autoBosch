<?php
// conexion.php: Conexión a la base de datos

$host = 'localhost';
$db = 'autoserviciobosch'; // Nombre de tu base de datos
$user = 'root'; // Cambia esto si tienes un usuario distinto
$pass = ''; // Cambia esto si tienes una contraseña

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    // Establecer el modo de error de PDO a excepción
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Registrar el error en un archivo de logs (opcional)
    error_log($e->getMessage(), 3, 'db_errors.log');
    // Mensaje de error genérico
    die("Error al conectar a la base de datos. Por favor, inténtelo más tarde.");
}
?>
