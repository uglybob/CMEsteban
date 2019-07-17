<?php

namespace CMEsteban\Lib;

class CustomController extends Controller
{
    // {{{ getPage
    public function getPageByRequest($id)
    {
        $page = new \CMEsteban\Page\CustomControllerPage();

        return $page->render();
    }
    // }}}
}
