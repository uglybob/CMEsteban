<?php

namespace CMEsteban\Page\Module;

class Text extends Module
{
    public function __construct($text, $createAnchors = true)
    {
        $this->createAnchors = $createAnchors;

        if (!is_string($text)) {
            $text = $text->getText();
        }

        $this->text = self::cleanText($text);

        parent::__construct();
    }

    protected function render()
    {
        $result = '';

        if ($this->text) {
            $result = HTML::div(['.ctext'], $this->text);
        }

        return $result;
    }

    public static function shortenString($text, $length)
    {
        return (strlen($text) > $length) ? substr($text, 0, $length - 3) . '...' : $text;
    }
    public static function replaceUrl($match, $createAnchors = true)
    {
        return new URL($match[0], $createAnchors);
    }
    protected static function replaceEmail($match, $createAnchors = true)
    {
        return new Email($match[0], $createAnchors);
    }
    public static function cleanLinebreaks($text)
    {
        $cleanRs = preg_replace("/\r/", '', $text);
        $clean = preg_replace("/\n/", HTML::br(), $cleanRs);

        return $clean;
    }
    public static function cleanText($input, $createAnchors = true)
    {
        $cleanLinks = preg_replace_callback(
            '@(\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))))@',
            function($match) use ($createAnchors) {
                return Text::replaceUrl($match, $createAnchors);
            },
            $input
        );

        $cleanMails = preg_replace_callback(
            '/[a-z\d._%+-]+@[a-z\d.-]+\.[a-z]{2,4}\b/i',
            function($match) use ($createAnchors) {
                return Text::replaceEmail($match, $createAnchors);
            },
            $cleanLinks
        );

        $clean = self::cleanLinebreaks($cleanMails);

        return $clean;
    }
}
