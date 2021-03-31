<?php

namespace IlBronza\Button;

use Illuminate\Support\Str;

class Button
{
    public $href;
    public $iframe = false;
    public $ajax;
    public $ajaxTableSelector;
    public $ukIcon;
    public $dgIcon;
    public $text;
    public $classes;
    public $flatWindow;
    public $type;
    public $tooltip;
    public $attributes = [];
    public $data = [];
    public $children = [];
    public $count = false;
    public $returnConfirm = false;
    private $hash;

    public function __construct(string $href = null, string $text = null, string $ukIcon = null, array $classes = [], array $parameters = [])
    {
        $this->href = $href;
        $this->text = $text;
        $this->ukIcon = $ukIcon;
        $this->classes = $classes;

        $this->hash = Str::uuid();

        $this->icon = $ukIcon;
    }

    public function setId(string $buttonId)
    {
        $this->id = $buttonId;
    }

    public function getId()
    {
        return $this->id ?? null;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function setAjaxTableButton(string $tableSelector = '.datatable', array $data = [])
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

    public function set(string $parameter, $value)
    {
        if(isset($this->$parameter))
            $this->$parameter = $value;
    }

    public function setReturnConfirm(string $confirmationMessage)
    {
        $this->returnConfirm = $confirmationMessage;
    }

    public function addCount(int $count)
    {
        $this->count = $count;
    }

    public function getClasses()
    {
        if($this->flatWindow)
            array_push($this->classes, 'flatwindow');

        return implode(" ", $this->classes);
    }

    public function isChild()
    {
        return true;
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

    public function renderLink()
    {
        return view('buttons::__a', ['button' => $this])->render();
    }

    public function renderBlankLink()
    {
        $this->blank = true;
        return view('buttons::__a', ['button' => $this])->render();
    }

    public function renderAsIframe()
    {
        $this->iframe = true;        
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

    public function tooltip(string $text = null)
    {
        if(! $text)
            return $this->tooltip;

        $this->tooltip = $text;

        return $this;
    }

    public function getName()
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

    /**
     * render javascript redirect for datatables buttons
     *
     * @return string 
     **/
    public function renderJsRedirect() : string
    {
        return "window.location.href='{$this->getHref()}'";
    }

}