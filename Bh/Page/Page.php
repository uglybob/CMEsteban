<?php

namespace Bh\Page;

use Bh\Page\Module\HTML;
use Bh\Page\Module\Email;
use Bh\Lib\Minify;

class Page
{
    // {{{ variables
    protected $controller;
    protected $title = '';
    protected $description = '';
    protected $keywords = [];
    protected $favicon = null;
    protected $stylesheets = [];
    protected $scripts = [];
    protected $accessLevel = 0;
    protected $path;
    protected $cacheable = false;
    // }}}

    // {{{ constructor
    public function __construct($controller, $path = [])
    {
        $this->controller = $controller;
        $this->path = $path;
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

    // {{{ addStylesheet
    public function addStylesheet($stylesheet)
    {
        if (!in_array($stylesheet, $this->stylesheets)) {
            $this->stylesheets[] = $stylesheet;
        }
    }
    // }}}
    // {{{ addScript
    public function addScript($script)
    {
        if (!in_array($script, $this->scripts)) {
            $this->scripts[] = $script;
        }
    }
    // }}}

    // {{{ renderStylesheets
    protected function renderStylesheets()
    {
        $rendered = '';

        if ($this->stylesheets) {
            $handles = Minify::minify('css', $this->stylesheets);

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

        if ($this->scripts) {
            $handles = Minify::minify('js', $this->scripts);

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
        if (!is_null($this->favicon)) {
            $rendered = HTML::link([
                'rel' => 'icon',
                'href' => $this->favicon,
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
    // {{{ renderContent
    protected function renderContent()
    {
        return '';
    }
    // }}}
    // {{{ wrapContent
    protected function wrapContent($content)
    {
        return HTML::div(['#content'], $content);
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
        $content = $this->wrapContent($this->renderContent());

        return '<!DOCTYPE html>' .
            HTML::html(
                $this->renderHead() . HTML::body($content)
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

    // {{{ guessSite
    public function guessSite($link)
    {
        $sites = array('facebook', 'bandcamp', 'youtube', 'soundcloud', 'twitter', 'vimeo', 'reverbnation', 'myspace');

        foreach($sites as $site) {
            if (preg_match('/' . $site . '/i', $link)) return $site;
        }

        return $link;
    }
    // }}}
    // {{{ replaceUrl
    public function replaceUrl($match)
    {
        $url = $match[0];

        $cleanedUrl = (preg_match("~^(?:f|ht)tps?://~i", $url)) ? $url : 'https://' . $url;

        $cleanedMatch = preg_replace('/(?:https?:\/\/)?(?:www\.)?(.*)\/?$/i', '$1', $cleanedUrl);
        $cleanedMatch = preg_replace('@\/$@', '', $cleanedMatch);
        $cleanedMatch = self::guessSite($cleanedMatch);
        $cleanedMatch = (strlen($cleanedMatch) > 33) ? substr($cleanedMatch, 0, 30) . '...' : $cleanedMatch;

        return HTML::a(['href' => $cleanedUrl],  ">$cleanedMatch");
    }
    // }}}
    // {{{ replaceEmail
    public function replaceEmail($match)
    {
        $email = $match[0];

        return new Email($email, $this);
    }
    // }}}
    // {{{ cleanText
    public function cleanText($input)
    {
        $cleanLinks = preg_replace_callback('@(\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))))@', [$this, 'replaceUrl'], htmlspecialchars($input));
        $cleanMails = preg_replace_callback('/[a-z\d._%+-]+@[a-z\d.-]+\.[a-z]{2,4}\b/i', [$this, 'replaceEmail'], $cleanLinks);
        $cleanRs = preg_replace("/\r/", '', $cleanMails);
        $cleanNs = preg_replace("/\n/", HTML::br(), $cleanRs);

        return $cleanNs;
    }
    // }}}
}
