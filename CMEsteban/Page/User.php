<?php

namespace CMEsteban\Page;

class User extends Home
{
    public function hookConstructor()
    {
        parent::hookConstructor();

        $this->cacheable = false;
        $this->addContent('main', new \CMEsteban\Page\Module\User());

        $user = $this->getController()->getCurrentUser();

        if ($user) {
            $this->title = $user->getName();
        } else {
            $this->title = 'register';
        }
    }
}
