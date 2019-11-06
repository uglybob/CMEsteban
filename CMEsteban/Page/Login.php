<?php

namespace CMEsteban\Page;

class Login extends Home
{
    // {{{ hookConstructor
    public function hookConstructor()
    {
        parent::hookConstructor();

        $this->cacheable = false;
        $this->addContent('main', new \CMEsteban\Page\Module\Login());
    }
    // }}}
}
