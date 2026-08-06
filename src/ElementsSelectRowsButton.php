<?php

namespace IlBronza\Buttons;

use InvalidArgumentException;

use function json_encode;
use function trans;

class ElementsSelectRowsButton extends Button
{
	public array $elements = [];
	public ?string $route = null;
	public array $routeParameters = [];
	public ?string $postUrl = null;
	public string $elementIdField = 'element_id';
	public string $selectedIdsField = 'ids';
	public ?string $placeholder = null;
	protected bool $elementsAreSet = false;

	public function __construct(array $parameters)
	{
		parent::__construct($parameters);

		if(array_key_exists('elements', $parameters))
			$this->setElements($parameters['elements']);
	}

	public function setElements(array $elements) : static
	{
		$this->elements = $elements;
		$this->elementsAreSet = true;

		return $this;
	}

	public function setRoute(string $route, array $parameters = []) : static
	{
		$this->route = $route;
		$this->routeParameters = $parameters;

		return $this;
	}

	public function setPostUrl(string $url) : static
	{
		$this->postUrl = $url;

		return $this;
	}

	public function setElementIdField(string $field) : static
	{
		$this->elementIdField = $field;

		return $this;
	}

	public function setSelectedIdsField(string $field) : static
	{
		$this->selectedIdsField = $field;

		return $this;
	}

	public function setPlaceholder(string $placeholder) : static
	{
		$this->placeholder = $placeholder;

		return $this;
	}

	public function getPostUrl() : string
	{
		if($this->postUrl)
			return $this->postUrl;

		if(! $this->route)
			throw new InvalidArgumentException('Set a post URL or a route for an elements select rows button.');

		return route($this->route, $this->routeParameters);
	}

	public function renderJsMethod()
	{
		if(! $this->elementsAreSet)
			throw new InvalidArgumentException('Set the elements for an elements select rows button.');

		$configuration = json_encode([
			'elements' => $this->elements,
			'url' => $this->getPostUrl(),
			'elementIdField' => $this->elementIdField,
			'selectedIdsField' => $this->selectedIdsField,
			'placeholder' => $this->placeholder ?? trans('buttons::buttons.selectElement'),
			'noSelectionMessage' => trans('buttons::buttons.selectAtLeastOneRow'),
		], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

		return "window.ibDtMountElementsSelectRows(node, dt, {$configuration});";
	}
}
