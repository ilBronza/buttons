<?php

namespace IlBronza\Buttons\Icons;

use IlBronza\Buttons\Icons\Icon;

class FaIcon extends Icon
{
    public $fillingType;
    public $viewType;

    static function inline(string $code)
    {
    	$icon = new static();
    	return $icon->setCode($code)->render();
    }

	public function getFillingType()
	{
		if($this->fillingType)
			return $this->fillingType;

		return config('buttons.faIcons.fillingType');
	}

	public function getViewType()
	{
		if($this->viewType)
			return $this->viewType;

		return config('buttons.faIcons.viewType');
	}

    public function getViewName()
    {
    	$viewType = $this->getViewType();

		return "buttons::faIcons.{$viewType}";
    }

    public function render() : string
    {
    	$viewName = $this->getViewName();

    	return view($viewName, ['icon' => $this])->render();
    }
}