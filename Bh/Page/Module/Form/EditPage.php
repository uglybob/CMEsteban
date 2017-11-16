<?php

namespace Bh\Page\Module\Form;

use Bh\Page\Page;

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

        $this->object->setRequest($values['Request']);
        $this->object->setPage($values['Page']);

        $this->controller->editPage($this->object);
    }
    // }}}
    // {{{ populate
    protected function populate()
    {
        $values = [
            'Request' => $this->object->getRequest(),
            'Page' => $this->object->getPage(),
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
