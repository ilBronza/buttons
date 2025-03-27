<?php

namespace IlBronza\Buttons\Traits;

trait ButtonChildrenTrait
{
	public function setContainsActiveElement(bool $contains = true) : static
	{
		$this->containsActiveElement = true;

		if($parent = $this->getParent())
			$parent->setContainsActiveElement($contains);

		return $this;
	}

	public function containsActiveElement() : bool
	{
		return !! $this->containsActiveElement;
	}

	public function getParent() : ? static
	{
		return $this->parent ?? null;
	}

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

	public function addButton(self $button)
	{
		return $this->addChild($button);
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
		if(! $result = $this->childrenColumnNumber)
			$result = $this->calculateChildrenColumnNumber();

		if($result > 6)
			return 6;

		return $result;
	}
}