<?php

namespace IlBronza\Buttons\Tests\Unit;

use IlBronza\Buttons\ElementsSelectRowsButton;
use IlBronza\Buttons\Tests\TestCase;
use Illuminate\Support\Facades\Route;
use InvalidArgumentException;

class ElementsSelectRowsButtonTest extends TestCase
{
	public function testItRequiresARoute()
	{
		$this->expectException(InvalidArgumentException::class);

		ElementsSelectRowsButton::create([
			'elements' => ['first' => 'Primo elemento']
		]);
	}

	public function testItRequiresElements()
	{
		$this->expectException(InvalidArgumentException::class);

		ElementsSelectRowsButton::create([
			'route' => 'rows.associate'
		]);
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

		$this->assertStringContainsString('select2', $javascript);
		$this->assertStringContainsString("type: 'POST'", $javascript);
		$this->assertStringContainsString('ibDtCollectSelectedRowIds(dt)', $javascript);
		$this->assertStringContainsString('data[elementIdField] = elementId', $javascript);
		$this->assertStringContainsString('data[selectedIdsField] = selectedIds', $javascript);
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
}
