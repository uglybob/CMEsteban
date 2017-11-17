<?php

namespace Bh\Lib;

class Mail
{
    // {{{ constructor
    public function __construct($src, $dst, $subject, $message)
    {
        $this->src = $src;
        $this->dst = $dst;
        $this->subject = $subject;
        $this->message = $message;
    }
    // }}}
    // {{{ send
    public function send()
    {
        $encoding = "utf-8";

        $preferences = [
            'input-charset' => $encoding,
            'output-charset' => $encoding,
            'line-length' => 76,
            'line-break-chars' => "\r\n"
        ];

        $header = "Content-type: text/html; charset=$encoding\r\n";
        $header .= 'From: ' . $this->src . ' <' . $this->src . ">\r\n";
        $header .= 'Reply-To: ' . $this->src . ' <' . $this->src . ">\r\n";
        $header .= iconv_mime_encode('Subject', $this->subject, $preferences) . "\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Transfer-Encoding: 8bit\r\n";
        $header .= "Date: " . date('r (T)') . "\r\n";
        $header .= "X-Mailer: CMEsteban Mailer";

        $result = \mail($this->dst, $this->subject, $this->message, $header);

        return $result;
    }
    // }}}
}
