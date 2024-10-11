<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php'); // Redirigir a la página de inicio de sesión
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autoservicio Bosch - Realizar Cotización</title>
    <link rel="icon" href="Imagenes/iconocra.jpg">
    <link rel="stylesheet" href="../Estilos/estilos.css">
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="menu container">
            <a href="Imagenes/LOGO AUTOSERVICIO BOSCH.png" class="logo">Logo</a>
            <input type="checkbox" id="menu"/>
            <label for="menu"></label>                
            <nav class="navbar">
                <ul>
                    <li><a href="Paginaprincipal.html">Inicio</a></li>
                    <li><a href="#sobre_nosotros">Sobre nosotros</a></li>
                    <li><a href="#contacto">Contacto</a></li>
                    <li><a href="#servicios">Servicios</a></li>
                    <li><a href="realizar_cotizacion.php">Realizar cotización</a></li>                   
                </ul>   
            </nav>
        </div>
    </header>

    <main>
        <h1>Enviar Cotización</h1>
        <form action="guardar_cotizacion.php" method="POST" enctype="multipart/form-data">
            <textarea name="comentario" placeholder="Describe la falla" required></textarea>
            <input type="file" name="imagen" accept="image/*" required>
            <button type="submit">Enviar Cotización</button>
        </form>
    </main>

    <footer class="footer" id="contacto">
        <div class="footer-content container">
            <div class="link">            
                <h3>Contáctenos</h3>
                <ul>
                    <li>Dirección: cl10a # 19b 194</li>
                    <li>Teléfono: 3115723666 - 3224747294</li>
                    <li>Correo: autoserviciobosh@gmail.com</li>
                </ul>
            </div>             
        </div>  
    </footer>
</body>
</html>
