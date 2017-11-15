<?php

namespace Bh\Page\Module;

use Bh\Lib\Mapper;
use Bh\Page\Page;

class DeleteObject extends FormModule
{
    // {{{ constructor
    public function __construct($controller, $page)
    {
        parent::__construct($controller, $page);

        $this->class = ucfirst($page->getPath(1));
        $this->id = $page->getPath(2);

        $object = $controller->{'get' . $this->class}($this->id);

        if (!$object) {
            Page::redirect('/' . lcfirst($this->class) . 's');
        }

        $name = method_exists($object, 'getName') ? $object->getName() : $object->getId();

        $this->form = new \Depage\HtmlForm\HtmlForm('delete' . $this->class, ['label' => 'delete']);
        $this->form->addBoolean('sure', ['label' => $name . ' delete?'])->setRequired();
        $this->form->process();

        if ($this->form->validate()) {
            $object->delete();
            Mapper::commit();
            $this->form->clearSession();

            Page::redirect('/' . lcfirst($this->class) . 's');
        }
    }
    // }}}
}
