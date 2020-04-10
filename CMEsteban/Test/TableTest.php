<?php

namespace CMEsteban\Test;

use CMEsteban\Page\Module\Table;

class TableTest extends CMEstebanTestCase
{
    public function testEmpty()
    {
        $table = new Table([], []);

        $this->assertEquals('<div class="ctable"><div class="ctheader"><div class="ctrow"></div></div></div>', $table->__toString());
    }
    public function testSimple()
    {
        $table = new Table(
            [
                ['0', '1'],
                ['2', '3'],
            ],
            ['attribute1', 'attribute2'],
        );

        $this->assertEquals('<div class="ctable">' .
            '<div class="ctheader">' .
                '<div class="ctrow">' .
                    '<div class="cthead">attribute1</div>' .
                    '<div class="cthead">attribute2</div>' .
                '</div>' .
            '</div>' .
            '<div class="ctrow">' .
                '<div class="ctcell">0</div>' .
                '<div class="ctcell">1</div>' .
            '</div>' .
            '<div class="ctrow">' .
                '<div class="ctcell">2</div>' .
                '<div class="ctcell">3</div>' .
            '</div>' .
        '</div>', $table->__toString());
    }
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
                '<div class="ctcell">0</div>' .
                '<div class="ctcell">1</div>' .
            '</div>' .
            '<div class="ctrow">' .
                '<div class="ctcell">2</div>' .
                '<div class="ctcell">3</div>' .
            '</div>' .
        '</div>', $table->__toString());
    }
}
