<?php

namespace CMEsteban\Page\Module;

use CMEsteban\CMEsteban;

class Text extends Module
{
    // {{{ constructor
    public function __construct($text, $createAnchors = true)
    {
        parent::__construct();

        $this->createAnchors = $createAnchors;
        $this->text = self::cleanText($text);
    }
    // }}}
    // {{{ toString
    public function __toString()
    {
        $result = '';

        if ($this->text) {
            $result = HTML::div(['.ctext'], $this->text);
        }

        return $result;
    }
    // }}}

    // {{{ shortenString
    public static function shortenString($text, $length)
    {
        return (strlen($text) > $length) ? substr($text, 0, $length - 3) . '...' : $text;
    }
    // }}}
    // {{{ shortenUrl
    public static function shortenUrl($url)
    {
        $sites = [
            'facebook',
            'bandcamp',
            'youtube',
            'soundcloud',
            'mixcloud',
            'twitter',
            'vimeo',
            'myspace',
        ];

        $host = parse_url($url, PHP_URL_HOST);

        foreach ($sites as $site) {
            if (preg_match('/' . $site . '/i', $host)) return $site;
        }

        $short = preg_replace('/(?:https?:\/\/)?(?:www\.)?(.*)\/?$/i', '$1', $url);
        $short = preg_replace('@\/$@', '', $short);

        return $short;
    }
    // }}}
    // {{{ replaceUrl
    public static function replaceUrl($match)
    {
        $url = $match[0];
        $result = $url;

        if ($this->createAnchors) {
            $cleanedUrl = (preg_match("~^(?:f|ht)tps?://~i", $url)) ? $url : 'https://' . $url;

            $short = self::shortenUrl($cleanedUrl);
            $trimmed = self::shortenString($short, 30);

            $result = HTML::a(['href' => $cleanedUrl],  ">$trimmed");
        }

        return $result;
    }
    // }}}
    // {{{ replaceEmail
    protected static function replaceEmail($match)
    {
        return new Email($match[0], $this->createAnchors);
    }
    // }}}
    // {{{ nl2br
    public static function nl2br($text)
    {
        $cleanRs = preg_replace("/\r/", '', $text);
        $clean = preg_replace("/\n/", HTML::br(), $cleanRs);

        return $clean;
    }
    // }}}
    // {{{ cleanText
    public static function cleanText($input)
    {
        $cleanLinks = preg_replace_callback('@(\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))))@', 'self::replaceUrl', $input);
        $cleanMails = preg_replace_callback('/[a-z\d._%+-]+@[a-z\d.-]+\.[a-z]{2,4}\b/i', 'self::replaceEmail', $cleanLinks);
        $clean = self::nl2br($cleanMails);

        return $clean;
    }
    // }}}
}
