<?php

namespace CMEsteban\Page;

use CMEsteban\CMEsteban;
use CMEsteban\Page\Module\HTML;
use CMEsteban\Page\Module\Email;
use CMEsteban\Lib\Minify;

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
    protected $content = [];
    // }}}

    // {{{ constructor
    public function __construct($path = [])
    {
        CMEsteban::$controller->access($this->accessLevel);

        CMEsteban::setPage($this);
        CMEsteban::setTemplate(CMEsteban::$setup->getTemplate($this));

        $this->path = $path;

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
        return CMEsteban::$template;
    }
    // }}}

    // {{{ renderStylesheets
    protected function renderStylesheets()
    {
        $rendered = '';
        $stylesheets = CMEsteban::$template->getStylesheets();

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
        $scripts = CMEsteban::$template->getScripts();

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
        $favicon = CMEsteban::$template->getFavicon();

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

    // {{{ addContent
    public function addContent($section, $content)
    {
        if (isset($this->content[$section])) {
            $this->content[$section] .= $content;
        } else {
            $this->setContent($section, $content);
        }
    }
    // }}}
    // {{{ setContent
    public function setContent($section, $content)
    {
        $this->content[$section] = $content;
    }
    // }}}
    // {{{ getContent
    public function getContent($section = null)
    {
        $result = '';

        if (is_null($section)) {
            $result = $this->content;
        } elseif (isset($this->content[$section])) {
            $result = HTML::div(["#$section"], $this->content[$section]);
        }

        return $result;
    }
    // }}}
    // {{{ render
    public function render()
    {
        return '<!DOCTYPE html>' .
            HTML::html(
                $this->renderHead() .
                HTML::body(
                    HTML::div(['#content'], CMEsteban::$template->render())
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

    // {{{ shortenString
    public static function shortenString($text, $length)
    {
        return (strlen($text) > $length) ? substr($text, 0, $length - 3) . '...' : $text;
    }
    // }}}
}
