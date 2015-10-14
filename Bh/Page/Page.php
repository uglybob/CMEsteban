<?php

namespace Bh\Page;

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
    // {{{ hookHeader
    protected function hookHeader()
    {
    }
    // }}}
    // {{{ hookTemplate
    protected function hookTemplate()
    {
        $this->template = new Template($this->controller);
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
        $header = HTML::head(
            HTML::title($this->hookTitle()) .
            HTML::link([
                'rel' => 'shortcut icon',
                'href' => '/Content/Images/favicon.ico',
                'type' => 'image/vnd.microsoft.icon',
            ]) .
            HTML::meta([
                'http-equiv' => 'Content-Type',
                'content' => 'text/html; charset=utf-8',
            ]) .
            HTML::meta([
                'name' => 'description',
                // @todo description hook
                'content' => ''
            ]) .
            $this->hookHeader() .
            $this->renderStylesheets()
        );

        return $header;
    }
    // }}}
    // {{{ renderHeader
    protected function renderHeader()
    {
        return '';
    }
    // }}}
    // {{{ renderFooter
    protected function renderFooter()
    {
        return '';
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
                        HTML::div(['#wrapper'],
                            HTML::div(['#header'], $this->template->header($this->renderHeader())) .
                            HTML::div(['#middle'], $this->template->content($this->renderContent())) .
                            HTML::div(['#footer'], $this->template->footer($this->renderFooter()))
                        )
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
