<?php

namespace Bh\Page;

use Bh\Lib\Html;

abstract class Page {
    protected $title;
    protected $stylesheets = [];
    protected $accessLevel = 0;

    // {{{ constructor
    public function __construct($controller, $path = [])
    {
        $this->controller = $controller;
    }
    // }}}

    // {{{ hookTitle
    protected function hookTitle()
    {
        return $this->title;
    }
    // }}}
    // {{{ hookHeader
    protected function hookHeader()
    {
    }
    // }}}

    // {{{ renderHead
    protected function renderHead() {
        // @todo content
        $header = Html::head('',
            Html::title('', $this->hookTitle()) .
            Html::link('rel="shortcut icon" href="/Content/Images/favicon.ico" type="image/vnd.microsoft.icon"') .
            Html::meta('http-equiv="Content-Type" content="text/html; charset=utf-8"') .
            Html::meta('name="description" content=\'The name "Brausehaus" stands for our underground music-collective.\'') .
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
            $renderedStylesheets .= Html::link('rel="stylesheet" href="' . $stylesheet . '"');
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
        $userLevel = 0;

        if ($currentUser = $this->controller->getCurrentUser()) {
            $userLevel = $currentUser->getLevel();
        }
 
        if (
            $userLevel >= $this->accessLevel
        ) {
            try {
                $string =   '<!DOCTYPE html>' .
                            Html::html('',
                                $this->renderHead() .
                                Html::body('',
                                    Html::div('id="main"',
                                        Html::div('id="middle"',
                                            $this->renderContent() .
                                            $this->renderFooter()
                                        )
                                    )
                                )
                            );

                return $string;
            } catch (\Exception $e) {
                $settings = \Bh\Lib\Setup::getSettings();

                if ($settings['DevMode'] === true) {
                    echo($e);
                }
            }
        } else {
            return 'Access denied';
        }
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
