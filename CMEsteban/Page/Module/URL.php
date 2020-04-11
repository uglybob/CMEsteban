<?php

namespace CMEsteban\Page\Module;

class URL extends Module
{
    public function __construct($url, $createAnchors = true, $settings = null)
    {
        $this->url = $url;
        $this->createAnchors = $createAnchors;
        $this->parsed = $this->parseUrl($this->url);
        $this->settings = is_null($settings) ? $this->getSetup()->getSettings('URL') : $settings;

        parent::__construct();
    }

    protected function getSetting($setting)
    {
        return (isset($this->settings[$setting])) ? $this->settings[$setting] : false;
    }

    protected function parseUrl($url)
    {
        $parsed = parse_url($url);

        if (
            !isset($parsed['host'])
            && isset($parsed['path'])
        ) {
            $parsed['host'] = $parsed['path'];
            unset($parsed['path']);
        }

        return $parsed;
    }
    protected function isDisplayed($component)
    {
        return (isset($this->parsed[$component])) ? $this->getSetting($component) : false;
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
        $prefix = $this->getSetting('prefix');
        $scheme = $this->isDisplayed('scheme') ? $this->parsed['scheme'] . '://' : '';
        $host = $this->isDisplayed('host') ? $this->parsed['host'] : '';
        $port = $this->isDisplayed('port') ? ':' . $this->parsed['port'] : '';
        $user = $this->isDisplayed('user') ? $this->parsed['user'] : '';
        $pass = $this->isDisplayed('pass') ? ':' . $this->parsed['pass'] : '';
        $pass = ($user || $pass) ? "$pass@" : '';
        $path = $this->isDisplayed('path') ? $this->parsed['path'] : '';
        $query = $this->isDisplayed('query') ? '?' . $this->parsed['query'] : '';
        $fragment = $this->isDisplayed('fragment') ? '#' . $this->parsed['fragment'] : '';
        $postfix = $this->getSetting('postfix');

        $result = "$prefix$scheme$user$pass$host$port$path$query$fragment$postfix";

        $maxLength = $this->getSetting('max_length');

        if ($maxLength) {
            $result = Text::shortenString($result, $maxLength);
        }

        return $result;
    }
}
