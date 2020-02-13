<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '..\vendor\autoload.php';

// Instantiation and passing `true` enables exceptions

function sendMail($to, $tipo, $idusr = 0, $add = 0)
{
    if ($tipo == 1) {
        //Body para confirmar mail
        if ($idusr != 0 && $add != "") {

            $param1 = "id";
            $param2 = $idusr;
            $param3 = "p";
            $param4 = $add;
            $param5 = "e";
            $param6 = $to;

            $link = "http://localhost/mendumy/registerhandler.php?" . $param1 . "=" . $param2 . "&" . $param3 . "=" . $param4 . "&" . $param5 . "=" . $param6;
        } else {
            $link = "error";
        }

        $subject = "Registro en Mendumy";
        $body =
            "<html>
        <body>
            <h3>Registro exitoso!</h3>
            Presione <a target='_blank' href= '" . $link . "'>aquí</a> para confirmar el registro!
        </body>
        </html>";
    }

    if ($tipo == 2) {
        //Body para confirmar mail
        if ($idusr != 0) {

            $param1 = "id";
            $param2 = $idusr;
            $param3 = "e";
            $param4 = $to;

            $link = "http://localhost/mendumy/restorepasshandler.php?" . $param1 . "=" . $param2 . "&" . $param3 . "=" . $param4;
        } else {
            $link = "error";
        }

        $subject = "Recuperar contraseña";
        $body =
            "<html>
        <body>
            <h3>Recuperar contraseña!</h3>
            Presione <a target='_blank' href= '" . $link . "'>aquí</a> para continuar con el proceso!
        </body>
        </html>";
    }


    $mail = new PHPMailer(true);

    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = '127.0.0.1';                    // Set the SMTP server to send through
        //$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        //$mail->Username   = 'papasfritas';                     // SMTP username
        //$mail->Password   = '123456';                               // SMTP password
        //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port       = 2500;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('from@example.com', 'Mailer');
        $mail->addAddress($to);     // Add a recipient

        // Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $body;


        if ($mail->send()) {
            return array("status" => 1, "msg" => "Mail enviado!");
        } else {
            return array("status" => 2, "msg" => "Error al enviar correo");
        }
    } catch (Exception $e) {
        return array("status" => 3, "msg" => "El mail no pudo ser enviado. {$mail->ErrorInfo}");
    }
}
