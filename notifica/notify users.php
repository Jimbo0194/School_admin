<?php
require_once(__DIR__ . '/database/database.php');
require_once(__DIR__ . '/vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarAlertas() {
    $db   = new Database();
    $conn = $db->getConnection();

    // Obtener todas las alertas pendientes
    $alertas = $conn->Execute(
        "SELECT id, correo, mensaje FROM alertas WHERE enviado = 0"
    )->GetRows();

    foreach ($alertas as $alerta) {
        $mail = new PHPMailer(true);
        try {
            // Configuración SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'edubenavidez17@gmail.com';
            $mail->Password   = 'mvxg oxwi bkxa oucx'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Destinatario y remitente
            $mail->setFrom('no-reply@tu-dominio.com', 'Notificaciones');
            $mail->addAddress($alerta['correo']);              

            // Contenido
            $mail->Subject = 'Alerta Académica';
            $mail->Body    = $alerta['mensaje'];

            $mail->send();

            // Marcar como enviado
            $conn->Execute(
                "UPDATE alertas SET enviado = 1 WHERE id = ?",
                [$alerta['id']]
            );
        } catch (Exception $e) {
            error_log("Error enviando alerta #{$alerta['id']}: {$mail->ErrorInfo}");
        }
    }
}

// Ejecutar desde CLI o cada hora al minuto 00
if (php_sapi_name() === 'cli' || date('i') === '00') {
    enviarAlertas();
}