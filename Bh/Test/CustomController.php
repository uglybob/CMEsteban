<?php

namespace Bh\Lib;

class CustomController extends Controller
{
    // {{{ getPage
    public function getPageByRequest($id)
    {
        $page = new \Bh\Page\CustomControllerPage();

        return $page->render();
    }
    // }}}
}
