<?php

namespace IlBronza\Buttons\Facades;

use Illuminate\Support\Facades\Facade;

class Button extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'button';
    }
}
