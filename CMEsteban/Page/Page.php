<?php

namespace CMEsteban\Page;

use CMEsteban\Page\Module\HTML;
use CMEsteban\Page\Module\Email;
use CMEsteban\Lib\Minify;
use CMEsteban\Lib\Setup;

class Page
{
    // {{{ variables
    protected $controller;
    protected $title = '';
    protected $description = '';
    protected $keywords = [];
    protected $accessLevel = 0;
    protected $path;
    protected $cacheable = false;
    // }}}

    // {{{ constructor
    public function __construct($controller, $path = [])
    {
        $this->controller = $controller;
        $this->path = $path;
        $this->template = Setup::getTemplate($this);
        $this->controller->access($this->accessLevel);

        $this->hookConstructor();
    }
    // }}}

    // {{{ getPath
    public function getPath($offset = null)
    {
        $path = null;

        if (is_null($offset)) {
            $path = $this->path;
        } else {
            $path = (isset($this->path[$offset])) ? $this->path[$offset] : null;
        }

        return $path;
    }
    // }}}

    // {{{ hookConstructor
    protected function hookConstructor()
    {
    }
    // }}}
    // {{{ hookTitle
    protected function hookTitle()
    {
        return $this->title;
    }
    // }}}
    // {{{ hookHead
    protected function hookHead()
    {
    }
    // }}}

    // {{{ getTemplate
    public function getTemplate()
    {
        return $this->template;
    }
    // }}}

    // {{{ renderStylesheets
    protected function renderStylesheets()
    {
        $rendered = '';
        $stylesheets = $this->template->getStylesheets();

        if ($stylesheets) {
            $handles = Minify::minify('css', $stylesheets);

            foreach ($handles as $handle) {
                $rendered .= HTML::link([
                    'type' => 'text/css',
                    'rel' => 'stylesheet',
                    'href' => $handle,
                ]);
            }
        }

        return $rendered;
    }
    // }}}
    // {{{ renderScripts
    protected function renderScripts()
    {
        $rendered = '';
        $scripts = $this->template->getScripts();

        if ($scripts) {
            $handles = Minify::minify('js', $scripts);

            foreach ($handles as $handle) {
                $rendered .= HTML::script([
                    'src' => $handle,
                ]);
            }
        }

        return $rendered;
    }
    // }}}
    // {{{ renderFavicon
    public function renderFavicon()
    {
        $favicon = $this->template->getFavicon();

        if (!is_null($favicon)) {
            $rendered = HTML::link([
                'rel' => 'icon',
                'href' => $favicon,
                'type' => 'image/x-icon',
            ]);
        } else {
            $rendered = '';
        }

        return $rendered;
    }
    // }}}

    // {{{ addKeywords
    public function addKeywords($keywords)
    {
        $this->keywords = array_merge($this->keywords, $keywords);
    }
    // }}}
    // {{{ renderHead
    protected function renderHead()
    {
        $head = HTML::head(
            $this->hookHead() .
            HTML::title($this->hookTitle()) .
            $this->renderFavicon() .
            HTML::meta(['charset' => 'UTF-8']) .
            HTML::meta(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0']) .
            (($this->description) ? HTML::meta(['name' => 'description', 'content' => $this->description]) : '') .
            (($this->keywords) ? HTML::meta(['name' => 'keywords', 'content' => implode(',', $this->keywords)]) : '') .
            HTML::meta(['name' => 'date.rendered', 'content' => date('r')]) .
            $this->renderStylesheets() .
            $this->renderScripts()
        );

        return $head;
    }
    // }}}

    // {{{ isCacheable
    public function isCacheable()
    {
        return $this->cacheable;
    }
    // }}}

    // {{{ render
    public function render()
    {
        // render content before head so module scripts are registered
        $content = $this->template->render();

        return '<!DOCTYPE html>' .
            HTML::html(
                $this->renderHead() .
                HTML::body(
                    HTML::div(['#content'], $content)
                )
            );
    }
    // }}}

    // {{{ redirect
    public static function redirect($url)
    {
        header('Location: ' . $url);
        die();
    }
    // }}}

    // {{{ shorten
    public function shorten($url)
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
    public function replaceUrl($match)
    {
        $url = $match[0];
        $cleanedUrl = (preg_match("~^(?:f|ht)tps?://~i", $url)) ? $url : 'https://' . $url;

        $short = $this->shorten($cleanedUrl);
        $trimmed = (strlen($short) > 33) ? substr($short, 0, 30) . '...' : $short;

        return HTML::a(['href' => $cleanedUrl],  ">$trimmed");
    }
    // }}}
    // {{{ replaceEmail
    protected function replaceEmail($match)
    {
        $email = $match[0];

        return new Email($this, $email);
    }
    // }}}
    // {{{ cleanText
    public function cleanText($input)
    {
        $cleanLinks = preg_replace_callback('@(\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))))@', [$this, 'replaceUrl'], $input);
        $cleanMails = preg_replace_callback('/[a-z\d._%+-]+@[a-z\d.-]+\.[a-z]{2,4}\b/i', [$this, 'replaceEmail'], $cleanLinks);
        $cleanRs = preg_replace("/\r/", '', $cleanMails);
        $cleanNs = preg_replace("/\n/", HTML::br(), $cleanRs);

        return $cleanNs;
    }
    // }}}
}
