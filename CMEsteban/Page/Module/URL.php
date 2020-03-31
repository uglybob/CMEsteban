<?php

namespace CMEsteban\Page\Module;

use CMEsteban\CMEsteban;

class URL extends Module
{
    public function __construct($url, $createAnchors = true)
    {
        $this->url = $url;
        $this->createAnchors = $createAnchors;
        $this->parsed = parse_url($this->url);

        parent::__construct();
    }

    protected function isDisplayed($component)
    {
        return
            isset($this->parsed[$component])
            && CMEsteban::$setup->getSettings("url_$component", true);
    }

    protected function render()
    {
        if ($this->createAnchors) {
            $result = HTML::a(['href' => $this->cleanUrl()], $this->renderUrl());
        } else {
            $result = $this->cleanUrl();
        }

        return $result;
    }

    protected function cleanUrl() {
        return (preg_match("~^(?:f|ht)tps?://~i", $this->url)) ? $this->url : 'https://' . $this->url;
    }

    protected function renderUrl() {
        $prefix = CMEsteban::$setup->getSettings('url_prefix', true);
        $scheme = $this->isDisplayed('scheme') ? $this->parsed['scheme'] . '://' : '';
        $host = $this->isDisplayed('host') ? $this->parsed['host'] : '';
        $port = $this->isDisplayed('port') ? ':' . $this->parsed['port'] : '';
        $user = $this->isDisplayed('user') ? $this->parsed['user'] : '';
        $pass = $this->isDisplayed('pass') ? ':' . $this->parsed['pass'] : '';
        $pass = ($user || $pass) ? "$pass@" : '';
        $path = $this->isDisplayed('path') ? $this->parsed['path'] : '';
        $query = $this->isDisplayed('query') ? '?' . $this->parsed['query'] : '';
        $fragment = $this->isDisplayed('fragment') ? '#' . $this->parsed['fragment'] : '';
        $postfix = CMEsteban::$setup->getSettings('url_postfix', true);

        $result = "$prefix$scheme$user$pass$host$port$path$query$fragment$postfix";

        $maxLength = CMEsteban::$setup->getSettings('url_max_length', true);

        if ($maxLength) {
            $result = Text::shortenString($result, $maxLength);
        }

        return $result;
    }
}
