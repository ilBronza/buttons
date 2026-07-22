<?php

namespace IlBronza\Buttons\Tests\Unit;

use IlBronza\Buttons\Button;
use IlBronza\Buttons\Tests\TestCase;

class ButtonChildrenTest extends TestCase
{
	private function button(array $parameters = []) : Button
	{
		return Button::create($parameters + ['name' => 'padre']);
	}

	public function testAddChildSetsParent()
	{
		$parent = $this->button();
		$child = Button::create(['name' => 'figlio']);

		$parent->addChild($child);

		$this->assertCount(1, $parent->getChildren());
		$this->assertSame($parent, $child->getParent());
		$this->assertTrue($child->isChild());
		$this->assertFalse($parent->isChild());
	}

	public function testAddButtonIsAnAliasOfAddChild()
	{
		$parent = $this->button();

		$parent->addButton(Button::create(['name' => 'figlio']));

		$this->assertCount(1, $parent->getChildren());
	}

	public function testAddChildFromArray()
	{
		$parent = $this->button();

		$parent->addChildFromArray(['name' => 'figlio', 'href' => 'https://example.com']);

		$this->assertEquals('figlio', $parent->getChildren()->first()->getName());
	}

	public function testChildrenByConstructorParameters()
	{
		$parent = $this->button([
			'children' => [
				['name' => 'uno'],
				['name' => 'due'],
				['name' => 'tre']
			]
		]);

		$this->assertTrue((bool) $parent->hasChildren());
		$this->assertCount(3, $parent->getChildren());
	}

	public function testChildrenPerColumnFallsBackToMenuConfig()
	{
		config(['menu.childrenPerColumn' => 5]);

		$parent = $this->button();

		$this->assertEquals(5, $parent->getChildrenPerColumn());

		$parent->setChildrenPerColumn(3);

		$this->assertEquals(3, $parent->getChildrenPerColumn());
	}

	public function testColumnNumberCalculation()
	{
		$parent = $this->button();
		$parent->setChildrenPerColumn(2);

		foreach(range(1, 5) as $index)
			$parent->addChildFromArray(['name' => 'figlio' . $index]);

		$this->assertEquals(3, $parent->getChildrenColumnNumber());
	}

	public function testColumnNumberIsCappedAtSix()
	{
		$parent = $this->button();
		$parent->setChildrenPerColumn(1);

		foreach(range(1, 10) as $index)
			$parent->addChildFromArray(['name' => 'figlio' . $index]);

		$this->assertEquals(6, $parent->getChildrenColumnNumber());
	}

	public function testContainsActiveElementPropagatesToParent()
	{
		$parent = $this->button();
		$child = Button::create(['name' => 'figlio']);

		$parent->addChild($child);
		$child->setContainsActiveElement();

		$this->assertTrue($child->containsActiveElement());
		$this->assertTrue($parent->containsActiveElement());
	}

	public function testDropdownModeDefaultsToHover()
	{
		$parent = $this->button();

		$this->assertEquals('hover', $parent->getDropdownMode());

		$parent->setDropdownMode('click');

		$this->assertEquals('click', $parent->getDropdownMode());
	}

	public function testDropdownModeReadsConfig()
	{
		config(['buttons.dropdownMode' => 'click']);

		$parent = $this->button();

		$this->assertEquals('click', $parent->getDropdownMode());
	}
}
