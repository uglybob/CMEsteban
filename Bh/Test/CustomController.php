<?php

namespace Bh\Lib;

class CustomController extends Controller
{
    // {{{ getPage
    public function getPageByRequest($id)
    {
        return new \Bh\Page\CustomControllerPage();
    }
    // }}}
}
