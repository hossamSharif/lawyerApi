<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer-master/src/SMTP.php';
require './PHPMailer-master/src/PHPMailer.php'; // Only file you REALLY 
require './PHPMailer-master/src/Exception.php'; // If you want to debug

//editired
 $emailTitle = $_GET['email'];
 $name = $_GET['name'];
 $offerId = $_GET['offerId'];
 $offerName = $_GET['offerName'];
 $start= $_GET['start'];
 $phone= $_GET['phone'];
 //$emailBody=> CharSet = 'UTF-8';
 
  // Get ID
 
//  $city->type = isset($_GET['type']) ? $_GET['type'] : die();
//Create an instance; passing `true` enables exceptions

$mail = new PHPMailer(true);
$mail-> CharSet = 'UTF-8';
try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'mail.aljoury.net';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'info@aljoury.net';                     //SMTP username
    $mail->Password   = 'Aljoury1990@';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('info@aljoury.net', 'aljoury center');
    $mail->addAddress($emailTitle, 'Joe User');     //Add a recipient
    $mail->addAddress('aljourycenter@gmail.com');  
     $mail->addAddress('info@aljoury.net');  
     //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject =  'تسجيل في دورة' .$offerName  .$start;
    $mail->Body    =   'الطالب '.$name. '<br>
   التاريخ '.$start. '<br>
   رقم الهاتف ' .$phone. '<br>
  البريد ' .$emailTitle.' <br>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}