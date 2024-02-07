<?php

namespace IlBronza\Buttons\Traits;

trait ButtonChildrenTrait
{
	public function setChildrenPerColumn(int $childrenPerColumn) : static
	{
		$this->childrenPerColumn = $childrenPerColumn;

		return $this;
	}

    public function isChild() : bool
    {
        return !! $this->parent;
    }

	public function hasChildren()
	{
		return count($this->getChildren());
	}

	public function getChildren()
	{
		return $this->children;
	}

	public function addChild(self $button)
	{
		$button->parent = $this;

		$this->children->push($button);

		$button->removeFromNavbar();
	}

	public function setDropdownColumns(int $dropdownColumns)
	{
		$this->dropdownColumns = $dropdownColumns;
	}

	public function addChildFromArray($parameters)
	{
		$button = static::create($parameters);

		$this->addChild(
			$button
		);

		// if($button->isNavbarButton())
		// 	$button->removeButtonHtmlClass('uk-button');
	}

	public function addChildrenFromArray(array $children)
	{
		foreach($children as $child)
			$this->addChildFromArray($child);
	}

	public function setChildrenByParameters(array $parameters)
	{
		if(! $children = ($parameters['children'] ?? false))
			return null;

		return $this->addChildrenFromArray($children);
	}

	public function getChildrenPerColumn()
	{
		return $this->childrenPerColumn ?? config('menu.childrenPerColumn');
	}

	public function calculateChildrenColumnNumber()
	{
		return ceil(count($this->getChildren()) / $this->getChildrenPerColumn());
	}

	public function getChildrenColumnNumber()
	{
		if($this->childrenColumnNumber)
			return $this->childrenColumnNumber;

		return $this->calculateChildrenColumnNumber();
	}
}