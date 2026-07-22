<?php

namespace IlBronza\Buttons\Tests\Unit;

use IlBronza\Buttons\Button;
use IlBronza\Buttons\Tests\TestCase;

class ButtonTextTest extends TestCase
{
	public function testShowTextDefaultsToTrue()
	{
		$button = Button::create(['name' => 'test']);

		$this->assertTrue($button->getShowText());
	}

	public function testHiddenTextReturnsEmptyString()
	{
		$button = Button::create(['name' => 'test', 'translatedText' => 'Ciao']);

		$button->setShowText(false);

		$this->assertEquals('', $button->getText());
	}

	public function testTranslatedTextWinsOverText()
	{
		$button = Button::create([
			'name' => 'test',
			'text' => 'buttons::buttons.edit',
			'translatedText' => 'Letterale'
		]);

		$this->assertEquals('Letterale', $button->getText());
	}

	public function testTextIsPassedThroughTrans()
	{
		$button = Button::create([
			'name' => 'test',
			'text' => 'buttons::buttons.edit'
		]);

		$this->assertEquals('Modifica', $button->getText());
	}

	public function testShowButtonTranslation()
	{
		$button = Button::create([
			'name' => 'test',
			'text' => 'buttons::buttons.show'
		]);

		$this->assertEquals('Mostra', $button->getText());
	}

	public function testNoTextReturnsEmptyString()
	{
		$button = Button::create(['name' => 'test']);

		$this->assertEquals('', $button->getText());
	}

	public function testSetEmptyText()
	{
		$button = Button::create([
			'name' => 'test',
			'text' => 'buttons::buttons.edit',
			'translatedText' => 'Letterale'
		]);

		$button->setEmptyText();

		$this->assertEquals('', $button->getText());
	}

	// regression: manca resources/lang/*/messages.php, quindi il default
	// di getReturnConfirmText() mostra la chiave grezza. quando verrà
	// aggiunto il file di lingua questo test va aggiornato
	public function testReturnConfirmDefaultTextIsUntranslatedKey()
	{
		$button = Button::create(['name' => 'test']);

		$this->assertEquals('buttons::messages.areYouSure', $button->getReturnConfirmText());
	}
}
