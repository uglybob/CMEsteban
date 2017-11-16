<?php

namespace Bh\Page\Module\Form;

use Bh\Lib\Controller;

class ImageSet extends \Depage\HtmlForm\Elements\Fieldset
{
    // {{{ constructor
    public function __construct($controller)
    {
        $this->addText('Name');
        $this->addText('Path');
        $this->addText('Alt');
    }
    // }}}
}
