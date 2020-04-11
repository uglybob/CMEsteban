<?php

namespace CMEsteban\Lib;

class CustomController extends Controller
{
    public function loadPage($request)
    {
        $page = new \CMEsteban\Page\CustomControllerPage();

        return $page->render();
    }
}
