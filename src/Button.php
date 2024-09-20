<?php

namespace IlBronza\Buttons;

use IlBronza\Buttons\Icons\Traits\UseIconTrait;
use IlBronza\Buttons\Traits\ButtonChildrenTrait;
use IlBronza\Buttons\Traits\ButtonGettersTrait;
use IlBronza\Buttons\Traits\ButtonPermissionsTrait;
use IlBronza\Buttons\Traits\ButtonRenderTrait;
use IlBronza\Buttons\Traits\ButtonSettersTrait;
use IlBronza\Buttons\Traits\ButtonStyleTrait;
use IlBronza\Buttons\Traits\ButtonTextTrait;
use IlBronza\Buttons\Traits\ButtonToggleTrait;
use IlBronza\Buttons\Traits\NewButtonMethodsTraitToRenameAfterHaveMovedEverything;
use IlBronza\Menu\Traits\InteractsWithNavbarTrait;
use IlBronza\UikitTemplate\Traits\UseTemplateTrait;
use Illuminate\Support\Str;

class Button
{
    use UseTemplateTrait;
    use UseIconTrait;

    use ButtonTextTrait;
    use ButtonChildrenTrait;

    use ButtonPermissionsTrait;
    use ButtonGettersTrait;
    use ButtonSettersTrait;
    use ButtonToggleTrait;
    use ButtonStyleTrait;

    use ButtonRenderTrait;

    use InteractsWithNavbarTrait;

    use NewButtonMethodsTraitToRenameAfterHaveMovedEverything;

    public ?bool $active = null;

    public $name;
    public $href;
    public $submit;
    public $iframe = false;
    public $lightbox = false;
    public $ajax;
    public $sortingIndex;
    public $ajaxTableSelector;
    // public $ukIcon;
    // public $dgIcon;
    public $value;
    public bool $containsActiveElement = false;
    public $classes = ['uk-button'];
    public $flatWindow;
    public $type;
    public ? string $image;
    public $tooltip;
    public $attributes = [];
    public $data = [];
    public $children;
    public $returnConfirm = false;
    public $target;
    private $hash;
    public $returnConfirmText;
    public $dropdownMode;

    public function setDropdownMode(string $mode = 'hover')
    {
        return $this->dropdownMode = $mode;
    }

    public function getDropdownMode() : string
    {
        return $this->dropdownMode ?? config('buttons.dropdownMode', 'hover');
    }

    //DEPRECATO
    public $ukIcon;

    public function getViewComponentName() : ? string
    {
        return 'buttons';
    }

    public function hasReturnConfirm() : bool
    {
        return $this->returnConfirm;
    }

    public function getReturnConfirmText() : ? string
    {
        return $this->returnConfirmText ?? trans('buttons::messages.areYouSure');
    }

    public function __construct(array $parameters)
    {
        foreach($parameters as $key => $value)
            $this->$key = $value;

        $this->setNameByParameters($parameters);
        $this->setIconByParameters($parameters);
        $this->setImageByParameters($parameters);

        $this->children = collect();
        $this->setChildrenByParameters($parameters);

        // $this->hash = Str::uuid();
    }

    public function setImageByParameters(array $parameters)
    {
        $this->image = $parameters['image'] ?? null;
    }

    static function create(array $parameters) : self
    {
        return new static(
            $parameters
        );
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function setAjaxTableButton(?string $tableSelector = '.datatable', array $data = [])
    {
        $this->ajax = true;
        $this->ajaxTableSelector = $tableSelector;

        $this->classes[] = 'ib-table-action-button';
        $this->data['route'] = $this->href;

        //deprecated, la tabella stessa setta il proprio ID
        $this->data['table'] = $tableSelector;

        foreach($data as $name => $value)
            $this->data[$name] = $value;
    }

    public function setTableId(string $tableId)
    {
        $this->data['tableid'] = $tableId;        
    }

    public function hasHref()
    {
        return !! $this->href;
    }

    public function setHref(string $href)
    {
        $this->href = $href;
    }

    public function getNoHrefValue()
    {
        return "javascript:void(0)";
    }

    public function getHref()
    {
        if(! empty($this->href))
            return $this->href;

        if(! empty($this->route))
            return route($this->route);

        if(! empty($this->routeName))
            return route($this->routeName, $this->routeParameters);

        return $this->getNoHrefValue();
    }

    public function setAttribute(string $attribute, string $value)
    {
        $this->attributes[$attribute] = $value;
    }

    public function haasValue()
    {
        return ! is_null($this->value);
    }

    public function getValue()
    {
        return $this->value;
    }

    public function set(string $parameter, $value)
    {
        if(isset($this->$parameter))
            $this->$parameter = $value;
    }

    public function setReturnConfirm(string $confirmationMessage = null)
    {
        $this->returnConfirm = true;
        $this->returnConfirmText = $confirmationMessage;
    }

    //DEPRECATED TO SET COUNT
    // public function addCount(int $count)
    // {
    //     $this->count = $count;
    // }

    public function setPrimary() : static
    {
        $this->classes[] = 'uk-button-primary';

        return $this;
    }

    public function setSecondary() : static
    {
        $this->classes[] = 'uk-button-secondary';

        return $this;
    }

    public function setDanger() : static
    {
        $this->setHtmlClass('uk-button-danger');

        return $this;
    }

    public function setHtmlClass(string $class) : static
    {
        $this->classes[] = $class;

        return $this;
    }

    public function setSmall() : static
    {
        $this->classes[] = 'uk-button-small';

        return $this;
    }

    public function getHtmlClasses()
    {
        if($this->flatWindow)
            array_push($this->classes, 'flatwindow');

        return $this->classes;
    }

    public function addClass(string $class)
    {
        $this->classes[] = $class;
    }

    public function getData()
    {
        return $this->data;
    }

    public function addData(array $data)
    {
        foreach($data as $name => $value)
            $this->data[$name] = $value;
    }

    public function renderLi()
    {
        return view('buttons::__listItem', ['button' => $this])->render();
    }

    public function isAjaxButton()
    {
        return $this->ajax;
    }

    // public function setIcon(string $icon)
    // {
    //     $this->ukIcon = $icon;
    // }

    //TODO DEPRECATED DA rimuovere una volta che non si usano più le uikit icons
    public function setUkIcon(string $icon)
    {
        //TODO DEPRECATED DA rimuovere una volta che non si usano più le uikit icons
        //TODO DEPRECATED DA rimuovere una volta che non si usano più le uikit icons
        //TODO DEPRECATED DA rimuovere una volta che non si usano più le uikit icons
        //TODO DEPRECATED DA rimuovere una volta che non si usano più le uikit icons
        $this->ukIcon = $icon;
        //TODO DEPRECATED DA rimuovere una volta che non si usano più le uikit icons
        //TODO DEPRECATED DA rimuovere una volta che non si usano più le uikit icons
        //TODO DEPRECATED DA rimuovere una volta che non si usano più le uikit icons
        //TODO DEPRECATED DA rimuovere una volta che non si usano più le uikit icons
    }
    //TODO DEPRECATED DA rimuovere una volta che non si usano più le uikit icons

    //DEPRECATED
    // public function setIconOrDefault(string $icon = null)
    // {
    //     if($icon)
    //         return $this->setUkIcon($icon);

    //     if($this->getIcon())
    //         return ;

    //     $this->setUkIcon('link');
    // }

    // public function renderIcon(string $icon = null)
    // {
    //     $this->setText();
    //     $this->setIconOrDefault($icon);

    //     return view('buttons::__a', ['button' => $this])->render();
    // }

    public function renderBlankLink()
    {
        $this->blank = true;
        return view('buttons::__a', ['button' => $this])->render();
    }

    public function renderImage() : ? string
    {
        if(! $this->image)
            return null;

        return '<img style="max-width: 45px;" src="' . $this->image . '" />';
    }

    public function renderAsIframe()
    {
        return $this->setAsIframe();
    }

    public function setAsIframe()
    {
        $this->iframe = true;

        return $this;
    }

    public function renderIFrame()
    {
        $this->iframe = true;
        return view('buttons::__a', ['button' => $this])->render();
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    // public function tooltip(string $tooltip = null)
    // {
    //     if(! $tooltip)
    //         return $this->tooltip;

    //     $this->tooltip = $tooltip;

    //     return $this;
    // }

    public function tooltip(string $tooltip = null)
    {
        $this->tooltip = $tooltip;

        return $this;
    }

    public function getName() : ? string
    {
        if(! empty($this->name))
            return $this->name;

        return Str::slug($this->text, '_');        
    }

    /**
     * return javascript methods for datatables buttons
     *
     * @return string
     **/
    public function renderJsMethod()
    {
        if(! $this->isAjax())
            return $this->renderJsRedirect();

        return;
    }

    public function isAjax()
    {
        return $this->ajax ?? false;
    }

    public function getTag()
    {
        if($this->hasHref())
            return 'a';

        return 'button';
    }

    public function hasTargetBlank()
    {
        return $this->getTarget() == '_blank';
    }

    public function getTarget()
    {
        return $this->target;
    }

    public function setTarget(string $target)
    {
        $this->target = $target;
    }

    public function setAsLightbox()
    {
        $this->lightbox = true;
    }

    public function hasLightbox() : bool
    {
        return !! $this->lightbox;
    }

    /**
     * render javascript redirect for datatables buttons
     *
     * @return string 
     **/
    public function renderJsRedirect() : string
    {
        $redirectString = $this->hasTargetBlank() ? "window.open('{$this->getHref()}')" : "window.location.href='{$this->getHref()}'";

        if($this->hasReturnConfirm())
            return "if (window.confirm('{$this->getReturnConfirmText()}')) {
                {$redirectString};
            }";

        return "{$redirectString};";
    }

    public function setSubmit() : static
    {
        $this->submit = true;

        $this->data['submit'] = true;

        if(! $this->value)
            $this->value = 1;

        return $this;
    }

    public function isSubmit()
    {
        return !! $this->submit;
    }

}