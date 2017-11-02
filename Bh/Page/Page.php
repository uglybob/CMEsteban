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
    protected $stylesheets = [];
    protected $scripts = [];
    protected $accessLevel = 0;
    protected $path;
    protected $cacheable;
    // }}}

    // {{{ constructor
    public function __construct($controller, $path = [])
    {
        $this->controller = $controller;
        $this->path = $path;
        $this->controller->access($this->accessLevel);

        $this->cacheable = true;

        $this->hookTemplate();
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
    // {{{ hookTemplate
    protected function hookTemplate()
    {
        $this->template = new Template();
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
        $stylesheets = array_merge($this->template->getStylesheets(), $this->stylesheets);

        foreach ($stylesheets as $stylesheet) {
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
        $scripts = array_merge($this->template->getScripts(), $this->scripts);

        foreach ($scripts as $script) {
            $rendered .= HTML::script([
                'type' => 'text/javascript',
                'src' => $script,
            ]);
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
            $this->template->favicon() .
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

    // {{{ getCacheFilename
    protected function getCacheFilename()
    {
        return Setup::getSettings('Path') . 'Bh/Cache/' . implode('-', $this->getPath()) . '.html';
    }
    // }}}
    // {{{ getCache
    protected function getCache()
    {
        $cache = false;

        if ($this->cacheable) {
            $name = $this->getCacheFilename();

            if (
                is_file($name)
                && ((time() - filemtime($name)) < Setup::getSettings('CacheTime'))
            ) {
                $cache = file_get_contents($name);
            }
        }

        return $cache;
    }
    // }}}
    // {{{ setCache
    protected function setCache($data)
    {
        file_put_contents($this->getCacheFilename(), $data);
    }
    // }}}

    // {{{ render
    public function render()
    {
        if ($cached = $this->getCache()) {
            $rendered = $cached;
        } else {
            $rendered = '<!DOCTYPE html>' .
                HTML::html(
                    $this->template->head($this->renderHead()) .
                    HTML::body(
                        HTML::div(['#main'],
                            $this->wrapContent($this->renderContent())
                        )
                    )
                );
            $this->setCache($rendered);
        }

        return $rendered;
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
