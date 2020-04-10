<?php

namespace CMEsteban\Lib;

class CustomController extends Controller
{
    public function renderPage($request)
    {
        $page = new \CMEsteban\Page\CustomControllerPage();

        return $page->render();
    }
}
