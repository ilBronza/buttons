<?php

namespace IlBronza\Buttons\Traits;

use Illuminate\Support\Str;

trait NewButtonMethodsTraitToRenameAfterHaveMovedEverything
{
	public $id;
    public $translatedText;
    public $text;
    public $count;

    public $icon;

    public $navbar;
    public $dropdownWidth;
    public $dropdownColumns = 1;

    public $toggle;

    public $parent;

    public $position;


    public $childrenColumnNumber;
    public $childrenPerColumn;

    /**
     * set the contect used to render the button. Due to multiple rendering
     * position possibility (ex primary menu and off-canvas), renderingContext 
     * add a prefix when button id is requested with getContextId()
     **/
    public $renderingContext;

    private function setNameByParameters(array $parameters)
    {
        if($parameters['name'] ?? false)
            return $this->name = $parameters['name'];

        foreach(['label', 'text', 'translatedText'] as $parameterName)
            if($parameters[$parameterName] ?? false)
                return $this->name = $parameters[$parameterName];

        if($parameters['href'] ?? false)
            return $this->name = Str::slug($parameters['href']);

        return $this->name = rand(0, 9999999);

        echo json_encode($parameters);

        die();

        throw new \Exception('Missing name parameter required for this button: ' . json_encode($parameters));
    }
}