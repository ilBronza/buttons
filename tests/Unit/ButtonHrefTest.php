<?php

namespace IlBronza\Buttons\Tests\Unit;

use IlBronza\Buttons\Button;
use IlBronza\Buttons\Tests\TestCase;
use Illuminate\Support\Facades\Route;

class ButtonHrefTest extends TestCase
{
	public function testDirectHrefWins()
	{
		$button = Button::create(['href' => 'https://example.com/diretto']);

		$this->assertTrue($button->hasHref());
		$this->assertEquals('https://example.com/diretto', $button->getHref());
	}

	public function testRoutePropertyIsResolved()
	{
		Route::get('pagina-rotta', fn () => 'ok')->name('pagina.rotta');

		$button = Button::create(['name' => 'test']);
		$button->route = 'pagina.rotta';

		$this->assertStringContainsString('pagina-rotta', $button->getHref());
	}

	public function testRouteNameWithParametersIsResolved()
	{
		Route::get('modelli/{id}/edit', fn ($id) => 'ok')->name('modelli.edit');

		$button = Button::create(['name' => 'test']);
		$button->routeName = 'modelli.edit';
		$button->routeParameters = ['id' => 42];

		$this->assertStringContainsString('modelli/42/edit', $button->getHref());
	}

	public function testJavascriptVoidFallback()
	{
		$button = Button::create(['name' => 'test']);

		$this->assertFalse($button->hasHref());
		$this->assertEquals('javascript:void(0)', $button->getHref());
	}

	public function testTagIsAnchorWithHref()
	{
		$button = Button::create(['href' => 'https://example.com']);

		$this->assertEquals('a', $button->getTag());
	}

	public function testTagIsButtonWithoutHref()
	{
		$button = Button::create(['name' => 'test']);

		$this->assertEquals('button', $button->getTag());
	}
}
