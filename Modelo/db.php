<?php
$host = 'localhost';
$db = 'autoserviciobosch'; 
$user = 'root'; 
$pass = ''; 

try {
    $conexion = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $errorConexion) {
    echo "Error de conexión: " . $errorConexion->getMessage();
}
?>
