<?php

namespace IlBronza\Buttons\Traits;

use IlBronza\CRUD\Helpers\UserRolesPermissionsHelpers\UserRolesPermissionsHelper;
use Illuminate\Support\Str;

use Auth;

trait ButtonRenderTrait
{
    public function render()
    {
		//buttons::uikit.button
        return $this->renderType('button');
    }

    public function renderSubmit()
    {
        return $this->renderType('submit');
    }

    public function renderLink()
    {
        return $this->renderA();
    }

    public function renderA()
    {
        $this->removeButtonHtmlClass('uk-button');

        return $this->renderType('button');
    }

    public function navbarRender(string $type = 'horizontal')
    {
        return $this->renderType('navbar.' . $type);
    }

    public function hasRenderingContext() : bool
    {
        return !! $this->renderingContext;
    }

    public function setRenderingContext(string $renderingContext)
    {
        $this->renderingContext = $renderingContext;
    }

    private function renderType(string $type) : ? string
    {
		if(! UserRolesPermissionsHelper::hasValidItemRoles($this))
			return null;

        $viewName = $this->getTemplateViewName($type);

        $this->setRenderingContext(Str::slug($viewName));

        return view($viewName, ['button' => $this])->render();
    }

    public function renderButton()
    {
        return $this->renderType('button');
    }

    public function getContextId()
    {
        return $this->renderingContext . $this->getId();
    }
}