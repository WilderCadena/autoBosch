<?php
$host = 'sql111.infinityfree.com';
$db = 'if0_39941919_autoserviciobosch'; 
$user = 'if0_39941919'; 
$pass = 'Wildrea2840';

try {
    $conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Conexión exitosa"; // puedes descomentar para probar
} catch (PDOException $errorConexion) {
    echo "Error de conexión: " . $errorConexion->getMessage();
}
?>

