<?php

namespace CMEsteban\Test;

use CMEsteban\Page\Module\Table;

class TableTest extends CMEstebanTestCase
{
    // {{{ setUp
    protected function setUp() : void
    {
        $this->controller = new \CMEsteban\Lib\Controller();
        $this->page = new PageTestClass($this->controller);
 
        parent::setUp();
    }
    // }}}

    // {{{ testEmpty
    public function testEmpty()
    {
        $table = new Table([]);

        $this->assertEquals('<div class="ctable"><div class="ctheader"><div class="ctrow"></div></div></div>', $table->__toString());
    }
    // }}}
    // {{{ testSimple
    public function testSimple()
    {
        $table = new Table([
            ['attribute1' => '0', 'attribute2' => '1'],
            ['attribute1' => '2', 'attribute2' => '3'],
        ]);

        $this->assertEquals('<div class="ctable">' .
            '<div class="ctheader">' .
                '<div class="ctrow">' .
                    '<div class="cthead">attribute1</div>' .
                    '<div class="cthead">attribute2</div>' .
                '</div>' .
            '</div>' .
            '<div class="ctrow">' .
                '<div class="attribute1 ctcell">0</div>' .
                '<div class="attribute2 ctcell">1</div>' .
            '</div>' .
            '<div class="ctrow">' .
                '<div class="attribute1 ctcell">2</div>' .
                '<div class="attribute2 ctcell">3</div>' .
            '</div>' .
        '</div>', $table->__toString());
    }
    // }}}
    // {{{ testSimpleAttributes
    public function testSimpleAttributes()
    {
        $table = new Table([
            ['attribute1' => '0', 'attribute2' => '1'],
            ['attribute1' => '2', 'attribute2' => '3'],
        ],
        [
            'attribute1' => 'Attribute I',
            'attribute2' => 'Attribute II',
        ]);

        $this->assertEquals('<div class="ctable">' .
            '<div class="ctheader">' .
                '<div class="ctrow">' .
                    '<div class="cthead">Attribute I</div>' .
                    '<div class="cthead">Attribute II</div>' .
                '</div>' .
            '</div>' .
            '<div class="ctrow">' .
                '<div class="Attribute_I ctcell">0</div>' .
                '<div class="Attribute_II ctcell">1</div>' .
            '</div>' .
            '<div class="ctrow">' .
                '<div class="Attribute_I ctcell">2</div>' .
                '<div class="Attribute_II ctcell">3</div>' .
            '</div>' .
        '</div>', $table->__toString());
    }
    // }}}
}
