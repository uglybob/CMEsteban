<?php

namespace CMEsteban\Page;

class Login extends Home
{
    // {{{ hookConstructor
    public function hookConstructor()
    {
        parent::hookConstructor();

        $this->template->addContent('main', new \CMEsteban\Page\Module\Login($this, $this->controller));
        $this->cacheable = false;
    }
    // }}}
}
