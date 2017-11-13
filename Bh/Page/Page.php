<?php

namespace Bh\Page;

use Bh\Page\Module\HTML;
use Bh\Lib\Setup;

abstract class Page
{
    // {{{ variables
    protected $controller;
    protected $title = '';
    protected $description = '';
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
    protected function getPath($offset = null)
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
    // {{{ hookDescripton
    protected function hookDescription()
    {
        return $this->description;
    }
    // }}}
    // {{{ hookHead
    protected function hookHead()
    {
    }
    // }}}

    // {{{ renderStylesheets
    protected function renderStylesheets()
    {
        $rendered = '';

        foreach ($this->stylesheets as $stylesheet) {
            $rendered .= HTML::link([
                'type' => 'text/css',
                'rel' => 'stylesheet',
                'href' => $stylesheet,
            ]);
        }

        return $rendered;
    }
    // }}}
    // {{{ renderScripts
    protected function renderScripts()
    {
        $rendered = '';

        foreach ($this->scripts as $script) {
            $rendered .= HTML::script([
                'type' => 'text/javascript',
                'src' => $script,
            ]);
        }

        return $rendered;
    }
    // }}}
    // {{{ renderFavicon
    public function renderFavicon()
    {
        if (!is_null($this->favicon)) {
            $rendered = HTML::link([
                'rel' => 'shortcut icon',
                'href' => $this->favicon,
                'type' => 'image/vnd.microsoft.icon',
            ]);
        } else {
            $rendered = '';
        }

        return $rendered;
    }
    // }}}

    // {{{ renderHead
    protected function renderHead()
    {
        $head = HTML::head(
            $this->hookHead() .
            HTML::title($this->hookTitle()) .
            $this->renderFavicon() .
            HTML::meta([
                'http-equiv' => 'Content-Type',
                'content' => 'text/html; charset=utf-8',
            ]) .
            HTML::meta([
                'name' => 'description',
                // @todo description hook
                'content' => ''
            ]) .
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
        return '<!DOCTYPE html>' .
            HTML::html(
                $this->renderHead() .
                HTML::body(
                    HTML::div(['#main'],
                        $this->wrapContent($this->renderContent())
                    )
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
}
