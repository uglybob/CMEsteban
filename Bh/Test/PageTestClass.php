<?php

namespace Bh\Test;

class PageTestClass extends \Bh\Page\Page
{
    public function getPath($offset = null)
    {
        return parent::getPath($offset);
    }
}
