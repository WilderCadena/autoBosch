<?php
// Controlador/enviar_recuperar.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../Libs/PHPMailer-master/src/PHPMailer.php';
require '../Libs/PHPMailer-master/src/SMTP.php';
require '../Libs/PHPMailer-master/src/Exception.php';

include("../Modelo/db.php");

$mensaje = "";
$error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['Correo'] ?? '');

    if (empty($correo)) {
        $mensaje = "❌ No se recibió correo.";
        $error = true;
    } else {
        $stmt = $conexion->prepare("SELECT * FROM registro WHERE Correo = ?");
        $stmt->execute([$correo]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            $mensaje = "❌ No se encontró ese correo en la base de datos.";
            $error = true;
        } else {
            $token = bin2hex(random_bytes(16));
            $update = $conexion->prepare("UPDATE registro SET reset_token = ? WHERE Correo = ?");
            $res = $update->execute([$token, $correo]);

            if (!$res) {
                $mensaje = "❌ Ha ocurrido un error. Por favor, inténtalo de nuevo.";
                $error = true;
            } else {
                $enlace = "https://autobosch.online/Controlador/reset_password.php?token=" . urlencode($token);

                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'wildercadena0828@gmail.com';
                    $mail->Password   = 'jlds quzc eunt ppbl';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587;
                    $mail->CharSet    = 'UTF-8';

                    $mail->setFrom('wildercadena0828@gmail.com', 'AutoBosch');
                    $mail->addAddress($correo);

                    $mail->isHTML(true);
                    $mail->Subject = 'Recuperación de contraseña - AutoBosch';
                    $mail->Body    = "
                        <h2>Solicitud de recuperación de contraseña</h2>
                        <p>Hola {$usuario['Nombres']}, haz solicitado restablecer tu contraseña.</p>
                        <p>Haz clic en el siguiente enlace para restablecerla:</p>
                        <p><a href='$enlace'>$enlace</a></p>
                        <p>Si no solicitaste esto, ignora este correo.</p>";

                    $mail->send();
                    $mensaje = "✅ Se ha enviado un enlace de recuperación a tu correo.";
                } catch (Exception $e) {
                    $mensaje = "❌ Ha ocurrido un error al enviar el correo: {$mail->ErrorInfo}";
                    $error = true;
                }
            }
        }
    }
} else {
    header("Location: ../Vista/recuperar.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Recuperación de contraseña</title>
<link rel="stylesheet" href="../Vista/estilos.css">
</head>
<body>

<div class="form-container <?= $error ? 'alert-error' : 'alert-success-container' ?>">
    <p><?= htmlspecialchars($mensaje) ?></p>
</div>

</body>
</html>
