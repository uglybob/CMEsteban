<?php

namespace Bh\Lib;

class Mail
{
    // {{{ constructor
    public function __construct($dst, $subject, $message)
    {
        $this->src = Setup::getSettings('MailAddress');
        $this->dst = $dst;
        $this->subject = $subject;
        $this->message = $message;
        $this->hostname = Setup::getSettings('MailHostname');
        $this->host = Setup::getSettings('MailHost');
        $this->pass = Setup::getSettings('MailPass');
    }
    // }}}
    // {{{ send
    public function send()
    {
        $success = true;

        try {
            $mail = new \PHPMailer(true);

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
            $mail->Username = $this->src;
            $mail->Password = $this->pass;
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
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
    // }}}
}
