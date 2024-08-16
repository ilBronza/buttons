<?php

namespace IlBronza\Buttons\Icons\Traits;

use IlBronza\Buttons\Icons\FaIcon;

trait UseIconTrait
{
    public function setIconByParameters(array $parameters)
    {
        if($icon = ($parameters['icon'] ?? false))
            $this->addFaIcon($icon);
    }

    public function setIcon(string $icon)
    {
        return $this->addFaIcon($icon);
    }

	public function addIcon(string $icon, string $type = 'faIcon')
	{
        //TODO DEPRECATED DA rimuovere una volta che non si usano più le uikit icons
        $this->setUkIcon($icon);

		if($type == 'faIcon')
			return $this->addFaIcon($icon);

		throw new \Exception('anche no icone diverse');
	}

	public function addFaIcon(string $icon)
	{
		$this->icon = FaIcon::create([
			'code' => $icon
		]);
	}

    public function getIcon()
    {
        if($this->icon)
            return $this->icon;

        //TODO DEPRECATED - Fare fuori tutto
        return $this->ukIcon;
    }

    public function hasFaIcon()
    {
    	if(! $icon = $this->getIcon())
    		return false;

    	return class_basename($icon) == 'FaIcon';
    }

    public function hasIcon() : bool
    {
        return $this->hasFaIcon();
    }

    public function renderIcon() : ? string
    {
        return $this->renderFaIcon();
    }

    public function renderFaIcon() : ? string
    {
    	if($this->hasFaIcon())
    		return $this->getIcon()->render();

    	return null;
    }
}