<?php

namespace Bh\Lib;

class CustomController extends Controller
{
    // {{{ getPage
    public function getPageByRequest()
    {
        return new \Bh\Page\CustomControllerPage();
    }
    // }}}
}
