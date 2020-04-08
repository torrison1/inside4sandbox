<?php

namespace Inside4\Mailing;

use PHPMailer;
use SMTP;

class Mailer {

    public $mailer;

    public $from_email;
    public $from_name;
    public $mail_password;


    public function init() {

        $this->from_email = $GLOBALS['inside4_main_config']['Mailer']['from_email'];
        $this->from_name = $GLOBALS['inside4_main_config']['Mailer']['from_name'];
        $this->mail_password = $GLOBALS['inside4_main_config']['Mailer']['mail_password'];

        require_once __DIR__ . '/PHPMailer/PHPMailer.php';
        require_once __DIR__ . '/PHPMailer/SMTP.php';
        $this->mailer = new \PHPMailer;

    }

    public function send_email($to_email, $message = 'Message from Inside', $subject = 'Inside') {

        $Mail = $this->mailer;

        try {
            $Mail->IsSMTP(); // Use SMTP

            $Mail->Host = "smtp.gmail.com"; // Sets SMTP server


            $Mail->SMTPDebug = 0; // 2 to enable SMTP debug information
            $Mail->SMTPAuth = TRUE; // enable SMTP authentication
            $Mail->SMTPSecure = "tls"; //Secure conection
            $Mail->Port = 587; // set the SMTP port

            $Mail->Username = $this->from_email; // SMTP account username
            $Mail->Password = $this->mail_password; // SMTP account password

            $Mail->Priority = 1; // Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
            $Mail->CharSet = 'UTF-8';
            $Mail->Encoding = '8bit';

            $Mail->Subject = $subject;
            $Mail->ContentType = 'text/html; charset=utf-8\r\n';
            $Mail->From = $this->from_email;
            $Mail->FromName = $this->from_name;
            $Mail->WordWrap = 900; // RFC 2822 Compliant for Max 998 characters per line

            $Mail->AddAddress($to_email); // To:
            $Mail->isHTML(TRUE);
            $Mail->Body = $message;
            $Mail->AltBody = $message;
            $Mail->Send();
            $Mail->SmtpClose();
        }catch (phpmailerException $e) {
            echo $e->errorMessage(); //Pretty error messages from PHPMailer
        } catch (Exception $e) {
            echo $e->getMessage(); //Boring error messages from anything else!
        }
        if ( $Mail->IsError() ) {
            return "ERROR";
        }
        else {
            return "OK";
        }
    }

}