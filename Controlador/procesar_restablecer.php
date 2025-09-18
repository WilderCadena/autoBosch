<?php
// Controlador/procesar_recuperacion.php
// 1) Recibe email, 2) genera token, 3) inserta en password_resets, 4) envía correo con link.

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: recuperar.php');
    exit;
}

$email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
if (!$email) {
    echo "Email inválido.";
    exit;
}

require_once '../Modelo/db.php'; // Ajusta ruta si tu db.php está en otra carpeta

try {
    // 1) Buscar usuario
    $stmt = $conexion->prepare("SELECT id, nombre FROM usuarios WHERE email = :email LIMIT 1"); // <-- REEMPLAZA 'usuarios' si tu tabla se llama distinto
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // Por seguridad no decir "no existe" — informar que se envió el correo (evitar enumeración)
        echo "Si el correo existe en el sistema, recibirás un enlace para restablecer la contraseña.";
        exit;
    }

    // 2) Generar token y expiración
    $token = bin2hex(random_bytes(16)); // 32 hex chars
    $expires_at = date('Y-m-d H:i:s', time() + 3600); // 1 hora

    // 3) Guardar token en tabla password_resets (eliminar anteriores)
    $del = $conexion->prepare("DELETE FROM password_resets WHERE email = :email");
    $del->execute([':email' => $email]);

    $ins = $conexion->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (:email, :token, :expires)");
    $ins->execute([':email' => $email, ':token' => $token, ':expires' => $expires_at]);

    // 4) Enviar correo con PHPMailer
    require_once '../Libs/PHPMailer-master/src/PHPMailer.php';
    require_once '../Libs/PHPMailer-master/src/SMTP.php';
    require_once '../Libs/PHPMailer-master/src/Exception.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $mail = new PHPMailer(true);
    try {
        // SMTP config — usa TU cuenta y contraseña de aplicación
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'TU_CORREO@gmail.com';          // <= reemplaza
        $mail->Password = 'TU_CONTRASEÑA_DE_APLICACION';  // <= reemplaza con password app
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('TU_CORREO@gmail.com', 'AutoBosch');
        $mail->addAddress($email, $user['nombre'] ?? '');

        $resetLink = 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/reset_password.php?token=' . $token;
        // si quieres que apunte a Controlador/reset_password.php: ajusta la URL arriba

        $mail->isHTML(true);
        $mail->Subject = 'Recuperación de contraseña';
        $mail->Body = "<p>Hola, solicitaste recuperar tu contraseña. Haz clic en el enlace para crear una nueva (válido 1 hora):</p>
                       <p><a href='{$resetLink}'>{$resetLink}</a></p>
                       <p>Si no solicitaste esto, ignora este correo.</p>";

        $mail->send();
        echo "Si el correo existe en el sistema, recibirás un enlace para restablecer la contraseña.";

    } catch (Exception $e) {
        // Loguear $mail->ErrorInfo si quieres
        echo "Error al enviar el correo. Intenta más tarde.";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
