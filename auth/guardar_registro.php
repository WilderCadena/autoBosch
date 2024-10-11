<?php
// Incluir el archivo de conexión
include 'conexion.php'; // Asegúrate de que la ruta sea correcta

// Verificar si se han enviado los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario y sanitizarlos
    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);
    $contraseña = trim($_POST['contraseña']);

    // Validación simple
    if (empty($nombres) || empty($apellidos) || empty($correo) || empty($telefono) || empty($contraseña)) {
        die("Por favor, complete todos los campos.");
    }

    // Hash de la contraseña
    $hashedPassword = password_hash($contraseña, PASSWORD_DEFAULT);

    try {
        // Preparar la consulta SQL
        $stmt = $pdo->prepare("INSERT INTO registro (Nombres, Apellidos, Correo, Telefono, Contraseña) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$nombres, $apellidos, $correo, $telefono, $hashedPassword])) {
            echo "Registro guardado exitosamente.";
        } else {
            echo "Error al guardar el registro.";
        }
    } catch (PDOException $e) {
        echo "Error al guardar el registro: " . $e->getMessage();
    }
}
?>
