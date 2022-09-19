<?php

namespace IlBronza\Buttons\Traits;

trait ButtonToggleTrait
{
	public function setToggle(string $elementId)
	{
		return $this->setToggleId($elementId);
	}

	public function setToggleId(string $elementId)
	{
		$this->toggle = '#' . $elementId;
	}

	public function setToggleClass(string $elementClass)
	{
		$this->toggle = '.' . $elementClass;
	}

	public function getToggle()
	{
		return $this->toggle;
	}

	public function renderToggle()
	{
		if(! $this->toggle)
			return null;

        $viewName = $this->getTemplateViewName('partials.toggle');

        return view($viewName, ['button' => $this]);
	}
}