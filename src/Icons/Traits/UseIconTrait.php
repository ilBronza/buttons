<?php

namespace IlBronza\Buttons\Icons\Traits;

use IlBronza\Buttons\Icons\FaIcon;

trait UseIconTrait
{
    /**
     * Sets an icon from the given parameters array if available.
     *
     * @param array $parameters
     * @return void
     */
    public function setIconByParameters(array $parameters)
    {
        if($icon = ($parameters['icon'] ?? false))
            $this->addFaIcon($icon);
    }

    /**
     * Sets the icon using a string identifier.
     *
     * @param string $icon
     * @return mixed
     */
    public function setIcon(string $icon)
    {
        return $this->addFaIcon($icon);
    }

    /**
     * Adds an icon depending on the specified type.
     * Deprecated: fallback to UIKit icons should be removed.
     *
     * @param string $icon
     * @param string $type
     * @return mixed
     *
     * @throws \Exception
     */
	public function addIcon(string $icon, string $type = 'faIcon')
	{
        //TODO DEPRECATED DA rimuovere una volta che non si usano più le uikit icons
        $this->setUkIcon($icon);

		if($type == 'faIcon')
			return $this->addFaIcon($icon);

		throw new \Exception('anche no icone diverse');
	}

    /**
     * Creates and assigns a FontAwesome icon instance.
     *
     * @param string $icon
     * @return void
     */
	public function addFaIcon(string $icon)
	{
		$this->icon = FaIcon::create([
			'code' => $icon
		]);
	}

    /**
     * Returns the currently assigned icon.
     * Falls back to UIKit icon if none is set.
     *
     * @return mixed
     */
    public function getIcon()
    {
        if($this->icon)
            return $this->icon;

        //TODO DEPRECATED - Fare fuori tutto
        return $this->ukIcon;
    }

    /**
     * Checks if the assigned icon is a FontAwesome icon.
     *
     * @return bool
     */
    public function hasFaIcon()
    {
    	if(! $icon = $this->getIcon())
    		return false;

    	return class_basename($icon) == 'FaIcon';
    }

    /**
     * Checks if any FontAwesome icon is assigned.
     *
     * @return bool
     */
    public function hasIcon() : bool
    {
        return $this->hasFaIcon();
    }

    /**
     * Renders the current icon.
     *
     * @return string|null
     */
    public function renderIcon() : ? string
    {
        return $this->renderFaIcon();
    }

    /**
     * Renders the FontAwesome icon if present.
     *
     * @return string|null
     */
    public function renderFaIcon() : ? string
    {
    	if($this->hasFaIcon())
    		return $this->getIcon()->render();

    	return null;
    }
}