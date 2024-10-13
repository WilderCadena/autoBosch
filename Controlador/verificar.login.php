<?php
session_start();
include '../Modelo/db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $contrasena = $_POST['password'];

    $stmtLogin = $conexion->prepare("SELECT * FROM registro WHERE Correo = ?");
    $stmtLogin->execute([$correo]);
    $usuario = $stmtLogin->fetch(PDO::FETCH_ASSOC); 

    if ($usuario) {
        
        if (password_verify($contrasena, $usuario['Contraseña'])) {
            
            $_SESSION['user_id'] = $usuario['id'];
            header("Location: cotizacion.php"); 
            exit();
        } else {
            echo "Correo o contraseña incorrectos.";
        }
    } else {
        echo "Correo o contraseña incorrectos.";
    }
}    else {
    header("Location: login.php");
    exit();
}
?>
