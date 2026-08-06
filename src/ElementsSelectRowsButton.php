<?php

namespace IlBronza\Buttons;

use InvalidArgumentException;

use function json_encode;
use function trans;

class ElementsSelectRowsButton extends Button
{
	public array $elements = [];
	public string $route;
	public array $routeParameters = [];
	public string $elementIdField = 'element_id';
	public string $selectedIdsField = 'ids';
	public ?string $placeholder = null;

	public function __construct(array $parameters)
	{
		if(empty($parameters['route']))
			throw new InvalidArgumentException('The route parameter is required for an elements select rows button.');

		if(! array_key_exists('elements', $parameters))
			throw new InvalidArgumentException('The elements parameter is required for an elements select rows button.');

		parent::__construct($parameters);
	}

	public function setElements(array $elements) : static
	{
		$this->elements = $elements;

		return $this;
	}

	public function setRoute(string $route, array $parameters = []) : static
	{
		$this->route = $route;
		$this->routeParameters = $parameters;

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

	public function getHref()
	{
		return route($this->route, $this->routeParameters);
	}

	public function renderJsMethod()
	{
		$jsonFlags = JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP;

		$options = json_encode($this->elements, $jsonFlags);
		$url = json_encode($this->getHref(), $jsonFlags);
		$elementIdField = json_encode($this->elementIdField, $jsonFlags);
		$selectedIdsField = json_encode($this->selectedIdsField, $jsonFlags);
		$placeholder = json_encode($this->placeholder ?? trans('buttons::buttons.selectElement'), $jsonFlags);
		$noSelectionMessage = json_encode(trans('buttons::buttons.selectAtLeastOneRow'), $jsonFlags);

		return <<<JS
window.__ibMountElementsSelectRows = window.__ibMountElementsSelectRows || function (node, dt, options, url, elementIdField, selectedIdsField, placeholder, noSelectionMessage)
{
	jQuery('.ib-elements-select-rows-floating').remove();

	var selectedIds = typeof window.ibDtCollectSelectedRowIds === 'function'
		? window.ibDtCollectSelectedRowIds(dt)
		: dt.rows({ selected: true }).data().pluck(window.__getIdColumnIndex(node, dt)).toArray();

	if (! selectedIds.length)
	{
		if (typeof window.addDangerNotification === 'function')
			window.addDangerNotification(noSelectionMessage);

		return;
	}

	var $button = jQuery(node);
	var offset = $button.offset();
	var $container = jQuery('<div class="ib-elements-select-rows-floating"></div>').css({
		position: 'absolute',
		top: offset.top + $button.outerHeight() + 4,
		left: offset.left,
		zIndex: 10090,
		minWidth: '320px',
		background: '#fff',
		padding: '8px',
		boxShadow: '0 5px 15px rgba(0,0,0,.15)'
	});
	var $select = jQuery('<select style="width: 100%;"></select>');

	$select.append(new Option('', '', true, true));

	jQuery.each(options, function (id, name)
	{
		$select.append(new Option(name, id, false, false));
	});

	$container.append($select);
	jQuery('body').append($container);

	var removeContainer = function ()
	{
		if ($select.data('select2'))
			$select.select2('destroy');

		$container.remove();
	};

	$select.select2({
		dropdownParent: $container,
		placeholder: placeholder,
		width: '100%'
	});

	$select.on('select2:select', function (e)
	{
		var elementId = e.params.data.id;

		if (! elementId)
			return;

		var data = {};
		data[elementIdField] = elementId;
		data[selectedIdsField] = selectedIds;

		jQuery.ajax({
			url: url,
			type: 'POST',
			data: data,
			headers: {
				'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content'),
				'X-Requested-With': 'XMLHttpRequest',
				'Accept': 'application/json'
			}
		}).always(removeContainer);
	});

	$select.on('select2:close', function ()
	{
		setTimeout(function ()
		{
			if (! $select.val())
				removeContainer();
		}, 150);
	});

	$select.select2('open');
};

window.__ibMountElementsSelectRows(node, dt, {$options}, {$url}, {$elementIdField}, {$selectedIdsField}, {$placeholder}, {$noSelectionMessage});
JS;
	}
}
