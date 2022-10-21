<?php

namespace IlBronza\Buttons\Traits;

trait ButtonStyleTrait
{
    public function getHtmlClassesString()
    {
    	if($this->isNavbarButton())
    		$this->removeButtonHtmlClass('uk-button');

        return implode(" ", $this->getHtmlClasses());        
    }

    public function removeButtonHtmlClass(string $class)
    {
		if (($key = array_search($class, $this->classes)) !== false)
			unset($this->classes[$key]);
    }
}