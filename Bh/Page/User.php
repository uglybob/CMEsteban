<?php

namespace Bh\Page;

use Bh\Lib\Controller;

class User extends Page
{
    // {{{ constructor
    public function __construct(Controller $controller, array $path)
    {
        parent::__construct($controller, $path);

        $this->stylesheets[] = '/vendor/depage/htmlform/lib/css/depage-forms.css';

        $id = $this->getPath(1);

        $settings = \Bh\Lib\Setup::getSettings();

        if (
            $settings['EnableRegistration']
            || $this->controller->getCurrentUser()
        ) {
            $this->registrationForm = new RegistrationForm($controller, 'User', $id);
        } else {
            $this->registrationForm = 'Registration disabled';
        }
    }
    // }}}

    // {{{ renderContent
    protected function renderContent()
    {
        return $this->registrationForm;
    }
    // }}}
}
