<?php

namespace CMEsteban\Lib;

use CMEsteban\CMEsteban;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    public function __construct($dst, $subject, $message)
    {
        $setup = $this->getSetup();

        $this->src = $setup->getSettings('MailAddress');
        $this->dst = $dst;
        $this->subject = $subject;
        $this->message = $message;
        $this->hostname = $setup->getSettings('MailHostname');
        $this->host = $setup->getSettings('MailHost');
        $this->pass = $setup->getSettings('MailPass');
    }
    public function send()
    {
        $success = true;

        try {
            $mail = new PHPMailer(true);

            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => true,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ]
            ];
            $mail->isSMTP();
            $mail->Host = $this->host;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Username = $this->src;
            $mail->Password = $this->pass;
            $mail->Port = 587;
            $mail->Hostname = $this->hostname;
            $mail->setFrom($this->src, $this->hostname);
            $mail->addAddress($this->dst);
            $mail->addReplyTo($this->src, $this->hostname);
            $mail->Subject = $this->subject;
            $mail->Body = $this->message;

            $mail->send();
        } catch (\Exception $e) {
            $success = false;
        }

        return $success;
    }
}
