<?php

namespace CMEsteban\Page\Module\Form;

use CMEsteban\CMEsteban;
use CMEsteban\Page\Page;

class EditPage extends EditForm
{
    // {{{ create
    protected function create()
    {
        $this->form->addText('Request');
        $this->form->addText('Page');
    }
    // }}}
    // {{{ save
    protected function save()
    {
        $values = $this->form->getValues();

        $this->entity->setRequest($values['Request']);
        $this->entity->setPage($values['Page']);

        CMEsteban::$controller->editPage($this->entity);
    }
    // }}}
    // {{{ populate
    protected function populate()
    {
        $values = [
            'Request' => $this->entity->getRequest(),
            'Page' => $this->entity->getPage(),
        ];

        $this->form->populate($values);
    }
    // }}}

    // {{{ redirect
    protected function redirect()
    {
        Page::redirect('/pages');
    }
    // }}}
}
