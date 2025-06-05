<?php

namespace IlBronza\Buttons\Icons;

use IlBronza\Buttons\Icons\Icon;

class FaIcon extends Icon
{
    public ? string $fillingType = null;
    public ? string $viewType = null;
    public array $htmlClasses = [];

    /**
     * Create a green check icon and return its rendered HTML.
     *
     * @return string
     */
    static function check()
    {
    	$icon = new static();
    	$icon->setCode('check');

    	$icon->setClass('uk-text-success');

    	return $icon->render();
    }

    /**
     * Create an inline edit icon.
     *
     * @return string
     */
	static function edit()
	{
		return static::inline('edit');
	}

    /**
     * Create an inline envelope icon representing email.
     *
     * @return string
     */
	static function email()
	{
		return static::inline('envelope');
	}

    /**
     * Create a red xmark icon and return its rendered HTML.
     *
     * @return string
     */
	static function xmark()
    {
    	$icon = new static();
		$icon->setCode('xmark');

    	$icon->setClass('uk-text-danger');

		return $icon->render();
    }

    /**
     * Create an inline icon with the given code.
     *
     * @param string $code Icon name.
     * @return string
     */
    static function inline(string $code)
    {
    	$icon = new static();
    	return $icon->setCode($code)->render();
    }

    /**
     * Add a CSS class to the icon.
     *
     * @param string $class The CSS class to add.
     * @return static
     */
    public function setClass(string $class) : static
	{
		$this->htmlClasses[] = $class;

		return $this;
	}

    /**
     * Get all HTML classes as an array.
     *
     * @return array
     */
	public function getHtmlClasses() : array
	{
		return $this->htmlClasses;
	}

    /**
     * Get all HTML classes as a space-separated string.
     *
     * @return string
     */
	public function getHtmlClassesString() : string
	{
		return implode(" ", $this->getHtmlClasses());
	}

    /**
     * Get the filling type of the icon, or fallback to config.
     *
     * @return string|null
     */
	public function getFillingType()
	{
		if($this->fillingType)
			return $this->fillingType;

		return config('buttons.faIcons.fillingType');
	}

    /**
     * Get the view type of the icon, or fallback to config.
     *
     * @return string|null
     */
	public function getViewType()
	{
		if($this->viewType)
			return $this->viewType;

		return config('buttons.faIcons.viewType');
	}

    /**
     * Build the view name string for rendering the icon.
     *
     * @return string
     */
    public function getViewName()
    {
    	$viewType = $this->getViewType();

		return "buttons::faIcons.{$viewType}";
    }

    /**
     * Render the icon using the resolved Blade view.
     *
     * @return string
     */
    public function render() : string
    {
    	$viewName = $this->getViewName();

    	return view($viewName, ['icon' => $this])->render();
    }
}