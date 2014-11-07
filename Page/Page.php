<?php

namespace BH\Page;

use BH\Lib\HTML;

abstract class Page {
    protected $title;
    protected $stylesheets = array();

    // {{{ constructor
    public function __construct($controller)
    {
        $this->controller = $controller;
    }
    // }}}

    // {{{ hookTitle
    protected function hookTitle() {
        return $this->title;
    }
    // }}}
    // {{{ hookHeader
    protected function hookHeader() {
    }
    // }}}

    // {{{ renderHead
    protected function renderHead() {
        $header =   HTML::head('',
                        HTML::title('', $this->hookTitle()) .
                        HTML::link('rel="shortcut icon" href="/Images/favicon.ico" type="image/vnd.microsoft.icon"') .
                        HTML::meta('http-equiv="Content-Type" content="text/html; charset=utf-8"') .
                        HTML::meta('name="description" content=\'The name "Brausehaus" stands for our underground music-collective.\'') .
                        $this->hookHeader() .
                        $this->renderStylesheets()
                    );

        return $header;
    }
    // }}}
    // {{{ renderStylesheets
    protected function renderStylesheets() {
        $renderedStylesheets = '';

        foreach ($this->stylesheets as $stylesheet) {
            $renderedStylesheets .= HTML::link('rel="stylesheet" href="' . $stylesheet . '"');
        }

        return $renderedStylesheets;
    }
    // }}}
    // {{{ renderFooter
    protected function renderFooter() {
        $footer =   '';
                    /* @todo loadScripts
                    '<script src="lib/jquery/jquery-2.0.3.min.js"></script>' .
                    '<script src="lib/eventlist.js"></script>' .
                    '<script src="lib/piwik.js"></script>' .
                    '<noscript><p><img src="http://piwik.bitbernd.de/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>' .
                    */

        return $footer;
    }
    // }}}

    // {{{ toString
    public function __toString()
    {
        $string =   '<!DOCTYPE html>' .
                    HTML::html('',
                        $this->renderHead() .
                        HTML::body('',
                            /* @todo
                            HTML::div('id="menubar"',
                                HTML::div('id="menu"',
                                    '<a href="/Was">Hä?</a>' .
                                    '<a href="/News">News</a>' .
                                    '<a href="/Kontakt">Kontakt</a>' .
                                    '<a href="/Impressum">Impressum</a>' .
                                )
                            ) .
                            */
                            HTML::div('id="main"',
                                // @todo '<div id="header"><a href="/"><img src="images/brausehaus.jpg" alt="*BRAUSEHAUS" /></a></div>' .
                                HTML::div('id="middle"',
                                    // @todo     '<div class="linkList">' . $this->renderMenu() . '</div>';
                                    $this->renderContent() .
                                    $this->renderFooter()
                                )
                            )
                        )
                    );

        return $string;
    }
    // }}}
}
