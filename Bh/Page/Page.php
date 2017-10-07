<?php

namespace Bh\Page;

use Bh\Page\Module\HTML;

abstract class Page
{
    // {{{ variables
    protected $controller;
    protected $title = '';
    protected $description = '';
    protected $stylesheets = [];
    protected $accessLevel = 0;
    protected $path;
    // }}}

    // {{{ constructor
    public function __construct($controller, $path = [])
    {
        $this->controller = $controller;
        $this->path = $path;
        $this->controller->access($this->accessLevel);

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

    // {{{ renderStylesheets
    protected function renderStylesheets()
    {
        $renderedStylesheets = '';
        $stylesheets = array_merge($this->template->getStylesheets(), $this->stylesheets);

        foreach ($stylesheets as $stylesheet) {
            $renderedStylesheets .= HTML::link([
                'rel' => 'stylesheet',
                'href' => $stylesheet,
            ]);
        }

        return $renderedStylesheets;
    }
    // }}}

    // {{{ renderHead
    protected function renderHead()
    {
        $head = HTML::head(
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
            $this->renderStylesheets()
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

    // {{{ render
    public function render()
    {
        return
            '<!DOCTYPE html>' .
            HTML::html(
                $this->template->head($this->renderHead()) .
                HTML::body(
                    HTML::div(['#main'],
                        HTML::div(['#content'], $this->template->content($this->renderContent()))
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
