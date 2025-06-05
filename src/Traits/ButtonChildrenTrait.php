<?php

namespace IlBronza\Buttons\Traits;

trait ButtonChildrenTrait
{
	/**
	 * Set whether this button or its children contain the active element.
	 *
	 * @param bool $contains
	 * @return static
	 */
	public function setContainsActiveElement(bool $contains = true) : static
	{
		$this->containsActiveElement = true;

		if($parent = $this->getParent())
			$parent->setContainsActiveElement($contains);

		return $this;
	}

	/**
	 * Check whether this button or its children contain the active element.
	 *
	 * @return bool
	 */
	public function containsActiveElement() : bool
	{
		return !! $this->containsActiveElement;
	}

	/**
	 * Get the parent button, if any.
	 *
	 * @return static|null
	 */
	public function getParent() : ? static
	{
		return $this->parent ?? null;
	}

	/**
	 * Set how many children should be displayed per column.
	 *
	 * @param int $childrenPerColumn
	 * @return static
	 */
	public function setChildrenPerColumn(int $childrenPerColumn) : static
	{
		$this->childrenPerColumn = $childrenPerColumn;

		return $this;
	}

    /**
     * Check if this button is a child (has a parent).
     *
     * @return bool
     */
    public function isChild() : bool
    {
        return !! $this->parent;
    }

	/**
	 * Check if this button has children.
	 *
	 * @return bool
	 */
	public function hasChildren()
	{
		return count($this->getChildren());
	}

	/**
	 * Get the collection of child buttons.
	 *
	 * @return \Illuminate\Support\Collection
	 */
	public function getChildren()
	{
		return $this->children;
	}

	/**
	 * Add a child button.
	 *
	 * @param self $button
	 * @return self
	 */
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

	/**
	 * Create and add a child button from an array of parameters.
	 *
	 * @param array $parameters
	 * @return void
	 */
	public function addChildFromArray($parameters)
	{
		$button = static::create($parameters);

		$this->addChild(
			$button
		);

		// if($button->isNavbarButton())
		// 	$button->removeButtonHtmlClass('uk-button');
	}

	/**
	 * Create and add multiple children from an array of arrays.
	 *
	 * @param array $children
	 * @return void
	 */
	public function addChildrenFromArray(array $children)
	{
		foreach($children as $child)
			$this->addChildFromArray($child);
	}

	/**
	 * Set children using a parameter array that includes a 'children' key.
	 *
	 * @param array $parameters
	 * @return void|null
	 */
	public function setChildrenByParameters(array $parameters)
	{
		if(! $children = ($parameters['children'] ?? false))
			return null;

		return $this->addChildrenFromArray($children);
	}

	/**
	 * Get the number of children to display per column.
	 *
	 * @return int
	 */
	public function getChildrenPerColumn()
	{
		return $this->childrenPerColumn ?? config('menu.childrenPerColumn');
	}

	/**
	 * Calculate the number of columns based on children count and per-column setting.
	 *
	 * @return int
	 */
	public function calculateChildrenColumnNumber()
	{
		return ceil(count($this->getChildren()) / $this->getChildrenPerColumn());
	}

	/**
	 * Get the number of columns to display for the children.
	 * Capped at 6 columns.
	 *
	 * @return int
	 */
	public function getChildrenColumnNumber()
	{
		if(! $result = $this->childrenColumnNumber)
			$result = $this->calculateChildrenColumnNumber();

		if($result > 6)
			return 6;

		return $result;
	}

	public function setDropdownColumns(int $dropdownColumns)
	{
		$this->dropdownColumns = $dropdownColumns;
	}
}