<?php

namespace IlBronza\Buttons\Traits;

use Illuminate\Support\Str;

trait ButtonGettersTrait
{
    public function isActive() : bool
    {
        return !! $this->active;
    }

	public function getCount()
	{
		return $this->count;
	}

    public function hasbadge() : bool
    {
        return !! ($this->badge ?? null);
    }

    public function getBadgeHtml() : ? string
    {
        return $this->badge;
    }

    public function getId()
    {
        if($this->id)
            return $this->id;

        $this->setId(Str::random(8));

        return $this->id;
    }

    public function getDropdownWidth() : ? string
    {
        if($this->dropdownWidth)
            return $this->dropdownWidth;

        if(! $this->isChild())
            return null;

        return 200 * $this->getChildrenColumnNumber() . 'px;';
    }
}