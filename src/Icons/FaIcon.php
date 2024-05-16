<?php

namespace IlBronza\Buttons\Icons;

use IlBronza\Buttons\Icons\Icon;

class FaIcon extends Icon
{
    public ? string $fillingType = null;
    public ? string $viewType = null;
    public array $htmlClasses = [];

    static function check()
    {
    	$icon = new static();
    	$icon->setCode('check');

    	$icon->setClass('uk-text-success');

    	return $icon->render();
    }

    static function edit()
    {
    	return static::inline('edit');
    }

    static function xmark()
    {
    	$icon = new static();
		$icon->setCode('xmark');

    	$icon->setClass('uk-text-danger');

		return $icon->render();
    }

    static function inline(string $code)
    {
    	$icon = new static();
    	return $icon->setCode($code)->render();
    }

    public function setClass(string $class) : static
	{
		$this->htmlClasses[] = $class;

		return $this;
	}

	public function getHtmlClasses() : array
	{
		return $this->htmlClasses;
	}

	public function getHtmlClassesString() : string
	{
		return implode(" ", $this->getHtmlClasses());
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