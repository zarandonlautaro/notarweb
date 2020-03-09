<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
//php mailer configurations
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '..\vendor\autoload.php';



// Instantiation and passing `true` enables exceptions
// la variable link contendra en enlace que enviaremos al correo del usuario, de momento se encuentra localhost/mendumy/mendumy para pruebas  en localhost
function sendMail($to, $tipo, $idusr = 0, $add = 0)
{
    //$directorio="localhost/mendumy2/mendumy/mendumy/";
    require '..\php\directorio.php';
    if ($tipo == 1) {
        //Body para confirmar mail
        if ($idusr != 0 && $add != "") {

            $param1 = "id";
            $param2 = $idusr;
            $param3 = "token";
            $param4 = $add;
            
           

            $link = "http://". $directorio ."registerhandler.php?" . $param1 . "=" . $param2 . "&" . $param3 . "=" . $param4 ;
        } else {
            $link = "error";
        }

        $subject = "Registro en Mendumy";
        $body =
            "<html>
        <body>
            <h3>¡Registro exitoso!</h3>
            Presione <a target='_blank' href= '" . $link . "'>aquí</a> para confirmar el registro.
        </body>
        </html>";
    }

    if ($tipo == 2) {
        //mail de recuperacion de contraseña
        if ($idusr != 0) {

            $param1 = "id";
            $param2 = $idusr;
            $param3 = "e";
            $param4 = $to;
            $param5 = 'token';
            $param6 = $add;
            

            $link = "http://".$directorio."restorepasshandler.php?" . $param1 . "=" . $param2 . "&" . $param3 . "=" . $param4 ."&" . $param5 . "=" . $param6;
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
        $mail->Host       = 'smtp.gmail.com'; //'127.0.0.1';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'brunomailtest@gmail.com';                     // SMTP username
        $mail->Password   = 'brunomailtest2020';                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port       = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('brunomailtest@gmail.com', 'Mailer');
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
