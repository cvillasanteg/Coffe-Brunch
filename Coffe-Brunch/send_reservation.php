<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Requiere el autoload de Composer
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizar la entrada para prevenir ataques XSS
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $people = htmlspecialchars(trim($_POST['people']));
    $date = htmlspecialchars(trim($_POST['date']));
    $time = htmlspecialchars(trim($_POST['time']));

    // Configuración del correo electrónico
    $to = "brunchoutbarcelona@gmail.com";
    $subject = "Nueva reserva desde Brunch Out Barcelona";
    $message = "
    Nombre: $name\n
    Email: $email\n
    Número de personas: $people\n
    Fecha: $date\n
    Hora: $time\n
    ";

    $mail = new PHPMailer(true);
    
    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();                                          // Establecer el uso de SMTP
        $mail->Host       = 'smtp.gmail.com';                     // Especificar servidores SMTP
        $mail->SMTPAuth   = true;                                // Habilitar autenticación SMTP
        $mail->Username   = 'brunchoutbarcelona@gmail.com';       // Nombre de usuario SMTP
        $mail->Password   = 'Brunchout4$';                        // Contraseña SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;        // Habilitar cifrado TLS
        $mail->Port       = 587;                                 // Puerto TCP para conectarse

        // Destinatarios
        $mail->setFrom('brunchoutbarcelona@gmail.com', 'Brunch Out Barcelona'); // Usa una dirección del dominio
        $mail->addAddress('brunchoutbarcelona@gmail.com');  // Añadir destinatario

        // Contenido
        $mail->isHTML(false);                                   // Establecer formato de correo a texto plano
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        echo 'Gracias por tu reserva. Nos pondremos en contacto contigo pronto.';
    } catch (Exception $e) {
        echo "Lo siento, hubo un problema al enviar tu reserva. Por favor, inténtalo de nuevo.";
        error_log("Error al enviar el correo de reserva de $name <$email>: " . $mail->ErrorInfo); // Registrar error
    }
} else {
    echo "Método de solicitud no soportado.";
}
?>

