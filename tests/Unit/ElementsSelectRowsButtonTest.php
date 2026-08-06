<?php

namespace IlBronza\Buttons\Tests\Unit;

use IlBronza\Buttons\ElementsSelectRowsButton;
use IlBronza\Buttons\Tests\TestCase;
use Illuminate\Support\Facades\Route;
use InvalidArgumentException;

class ElementsSelectRowsButtonTest extends TestCase
{
	public function testItRequiresARouteOrPostUrlWhenRendering()
	{
		$this->expectException(InvalidArgumentException::class);

		$button = ElementsSelectRowsButton::create([
			'elements' => ['first' => 'Primo elemento']
		]);

		$button->renderJsMethod();
	}

	public function testItRequiresElementsWhenRendering()
	{
		$this->expectException(InvalidArgumentException::class);

		$button = ElementsSelectRowsButton::create([]);
		$button->setPostUrl('https://example.com/rows/associate');

		$button->renderJsMethod();
	}

	public function testItRendersSelect2PostWithTheSelectedRows()
	{
		Route::post('rows/associate/{container}', fn () => 'ok')->name('rows.associate');

		$button = ElementsSelectRowsButton::create([
			'route' => 'rows.associate',
			'routeParameters' => ['container' => 42],
			'elements' => ['supplier-1' => 'Fornitore Uno'],
		]);

		$javascript = $button->renderJsMethod();

		$this->assertStringStartsWith('window.ibDtMountElementsSelectRows(node, dt, ', $javascript);
		$this->assertStringNotContainsString('select2', $javascript);
		$this->assertStringNotContainsString("type: 'POST'", $javascript);
		$this->assertStringContainsString('"elementIdField":"element_id"', $javascript);
		$this->assertStringContainsString('"selectedIdsField":"ids"', $javascript);
		$this->assertStringContainsString('rows/associate/42', $javascript);
		$this->assertStringContainsString('supplier-1', $javascript);
	}

	public function testItAllowsCustomPayloadFieldNames()
	{
		Route::post('rows/associate', fn () => 'ok')->name('rows.associate.custom');

		$button = ElementsSelectRowsButton::create([
			'route' => 'rows.associate.custom',
			'elements' => ['target-1' => 'Target Uno'],
		]);

		$button->setElementIdField('target_id')->setSelectedIdsField('row_ids');

		$javascript = $button->renderJsMethod();

		$this->assertStringContainsString('"target_id"', $javascript);
		$this->assertStringContainsString('"row_ids"', $javascript);
	}

	public function testItCanBeConfiguredWithFluentMethods()
	{
		$button = ElementsSelectRowsButton::create([
			'text' => 'Associa elementi'
		]);

		$this->assertSame($button, $button->setElements(['target-1' => 'Target Uno']));
		$this->assertSame($button, $button->setPostUrl('https://example.com/rows/associate'));

		$javascript = $button->renderJsMethod();

		$this->assertStringContainsString('https://example.com/rows/associate', $javascript);
		$this->assertStringContainsString('target-1', $javascript);
	}
}
