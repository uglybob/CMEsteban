<?php

namespace Bh\Page;

use Bh\Page\Module\HTML;

class Template
{
    // {{{ getStylesheets
    public function getStylesheets()
    {
        return $this->stylesheets;
    }
    // }}}
    // {{{ getScripts
    public function getScripts()
    {
        return $this->scripts;
    }
    // }}}

    // {{{ head
    public function head($head)
    {
        return $head;
    }
    // }}}
}
