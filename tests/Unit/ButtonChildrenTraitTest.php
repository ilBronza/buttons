<?php

use PHPUnit\Framework\TestCase;

class ButtonChildrenTraitTest extends TestCase
{
    protected function getButtonWithTrait()
    {
        return new class {
            use \IlBronza\Buttons\Traits\ButtonChildrenTrait;
            public $children;
            public function __construct() { $this->children = collect(); }
        };
    }

    public function testAddChild()
    {
        $parent = $this->getButtonWithTrait();
        $child = $this->getButtonWithTrait();

        $parent->addButton($child);
        $this->assertCount(1, $parent->getChildren());
    }

    public function testSetChildrenPerColumn()
    {
        $button = $this->getButtonWithTrait();
        $button->setChildrenPerColumn(3);
        $this->assertEquals(3, $button->getChildrenPerColumn());
    }
}
