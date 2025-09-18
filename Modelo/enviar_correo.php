<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Requiere las clases de PHPMailer (ajusta la ruta si es diferente)
require '../Libs/PHPMailer-master/src/PHPMailer.php';
require '../Libs/PHPMailer-master/src/SMTP.php';
require '../Libs/PHPMailer-master/src/Exception.php';

function enviarCorreoCotizacion($paraCliente, $nombreCliente, $comentario, $adminCorreo, $imagenPath = null) {
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'wildercadena0828@gmail.com'; // correo
        $mail->Password = 'jlds quzc eunt ppbl';           // 👈 Reemplaza esto por la clave generada
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Codificación
        $mail->CharSet = 'UTF-8';

        // Emisor
        $mail->setFrom('wildercadena0828@gmail.com', 'AutoBosch');

        // Destinatario principal (cliente)
        $mail->addAddress($paraCliente, $nombreCliente);

        // Copia oculta al administrador
        $mail->addBCC($adminCorreo, 'Administrador AutoBosch');

        // Adjuntar imagen (opcional)
        if ($imagenPath && file_exists($imagenPath)) {
            $mail->addAttachment($imagenPath);
        }

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Confirmación de cotización - AutoBosch';
        $mail->Body = "
            <h2>Hola, $nombreCliente 👋</h2>
            <p>Tu solicitud de cotización fue recibida exitosamente.</p>
            <p><strong>Comentario:</strong><br>$comentario</p>
            <p>Nos pondremos en contacto contigo pronto.</p>
            <br><p><strong>AutoBosch</strong></p>
        ";

        $mail->send();
        return true;

    } catch (Exception $e) {
        return "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}
