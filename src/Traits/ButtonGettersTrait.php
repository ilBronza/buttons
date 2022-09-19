<?php

namespace IlBronza\Buttons\Traits;

use Illuminate\Support\Str;

trait ButtonGettersTrait
{
	public function getCount()
	{
		return $this->count;
	}

    public function getId()
    {
        if($this->id)
            return $this->id;

        $this->setId(Str::random(8));

        return $this->id;
    }
}