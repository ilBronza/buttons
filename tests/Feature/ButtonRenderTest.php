<?php

namespace IlBronza\Buttons\Tests\Feature;

use IlBronza\Buttons\Button;
use IlBronza\Buttons\Tests\TestCase;

class ButtonRenderTest extends TestCase
{
	public function testRenderProducesAnchorWithHrefTextAndClasses()
	{
		$button = Button::create([
			'name' => 'salva',
			'href' => 'https://example.com/salva',
			'translatedText' => 'Salva elemento'
		]);

		$html = $button->render();

		$this->assertStringContainsString('<a', $html);
		$this->assertStringContainsString('href="https://example.com/salva"', $html);
		$this->assertStringContainsString('Salva elemento', $html);
		$this->assertStringContainsString('uk-button', $html);
		$this->assertStringContainsString('salva', $html);
	}

	public function testRenderTranslatesTextKey()
	{
		$button = Button::create([
			'name' => 'edit',
			'href' => 'https://example.com/edit',
			'text' => 'buttons::buttons.edit'
		]);

		$this->assertStringContainsString('Modifica', $button->render());
	}

	public function testRenderWithoutHrefFallsBackToJavascriptVoid()
	{
		$button = Button::create(['name' => 'vuoto']);

		$this->assertStringContainsString('javascript:void(0)', $button->render());
	}

	public function testDataAttributesAreRendered()
	{
		$button = Button::create([
			'name' => 'dati',
			'href' => 'https://example.com'
		]);

		$button->setData('chiave', 'valore');

		$this->assertStringContainsString('data-chiave="valore"', $button->render());
	}

	public function testReturnConfirmRendersOnclick()
	{
		$button = Button::create([
			'name' => 'elimina',
			'href' => 'https://example.com/elimina'
		]);

		$button->setReturnConfirm('Sicuro di eliminare?');

		$html = $button->render();

		$this->assertStringContainsString('onclick="return confirm(', $html);
		$this->assertStringContainsString('Sicuro di eliminare?', $html);
	}

	public function testTargetBlankIsRendered()
	{
		$button = Button::create([
			'name' => 'esterno',
			'href' => 'https://example.com'
		]);

		$button->setBlank();

		$this->assertStringContainsString('target="_blank"', $button->render());
	}

	public function testDisabledAttributeIsRendered()
	{
		$button = Button::create([
			'name' => 'spento',
			'href' => 'https://example.com'
		]);

		$button->setDisabled();

		$this->assertStringContainsString('disabled', $button->render());
	}

	public function testRenderARemovesUkButtonClass()
	{
		$button = Button::create([
			'name' => 'link',
			'href' => 'https://example.com'
		]);

		$this->assertStringNotContainsString('uk-button', $button->renderA());
	}

	public function testRenderSubmitProducesSubmitButton()
	{
		$button = Button::create([
			'name' => 'invia',
			'translatedText' => 'Invia'
		]);

		$button->setSubmit();

		$html = $button->renderSubmit();

		$this->assertStringContainsString('<button', $html);
		$this->assertStringContainsString('type="submit"', $html);
		$this->assertStringContainsString('name="invia"', $html);
		$this->assertStringContainsString('value="1"', $html);
		$this->assertStringContainsString('Invia', $html);
	}

	public function testRenderWithFaIcon()
	{
		$button = Button::create([
			'name' => 'penna',
			'href' => 'https://example.com',
			'icon' => 'pen'
		]);

		$html = $button->render();

		$this->assertStringContainsString('fa-pen', $html);
		$this->assertStringContainsString('fa-solid', $html);
	}

	public function testRenderWithChildrenProducesDropdown()
	{
		$button = Button::create([
			'name' => 'menu',
			'href' => 'https://example.com',
			'children' => [
				['name' => 'primo', 'href' => 'https://example.com/1'],
				['name' => 'secondo', 'href' => 'https://example.com/2']
			]
		]);

		$html = $button->render();

		$this->assertStringContainsString('uk-navbar-dropdown', $html);
		$this->assertStringContainsString('uk-nav-parent-icon', $html);
	}

	public function testRenderToggle()
	{
		$button = Button::create([
			'name' => 'apri',
			'href' => 'https://example.com'
		]);

		$button->setToggle('pannello');

		$this->assertStringContainsString('uk-toggle="target: #pannello"', $button->render());
	}

	public function testRenderImage()
	{
		$button = Button::create([
			'name' => 'immagine',
			'href' => 'https://example.com',
			'image' => 'https://example.com/foto.png'
		]);

		$this->assertStringContainsString('<img', $button->render());
	}

	public function testRenderJsRedirect()
	{
		$button = Button::create([
			'name' => 'redirect',
			'href' => 'https://example.com/vai'
		]);

		$this->assertStringContainsString("window.location.href='https://example.com/vai'", $button->renderJsRedirect());

		$button->setBlank();

		$this->assertStringContainsString("window.open('https://example.com/vai')", $button->renderJsRedirect());
	}

	public function testRenderJsRedirectWithConfirm()
	{
		$button = Button::create([
			'name' => 'conferma',
			'href' => 'https://example.com/vai'
		]);

		$button->setReturnConfirm('Procedere?');

		$this->assertStringContainsString("window.confirm('Procedere?')", $button->renderJsRedirect());
	}
}
