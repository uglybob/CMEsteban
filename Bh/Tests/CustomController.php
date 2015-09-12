<?php

namespace Bh\Lib;

class CustomController extends Controller
{
    // {{{ getPage
    public function getPageByRequest()
    {
        return 'This is a custom controller page.';
    }
    // }}}
}
