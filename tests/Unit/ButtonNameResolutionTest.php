<?php

namespace IlBronza\Buttons\Tests\Unit;

use IlBronza\Buttons\Button;
use IlBronza\Buttons\Tests\TestCase;
use Illuminate\Support\Str;

class ButtonNameResolutionTest extends TestCase
{
	public function testNameParameterWins()
	{
		$button = Button::create([
			'name' => 'mioNome',
			'text' => 'testo',
			'href' => 'https://example.com/edit'
		]);

		$this->assertEquals('mioNome', $button->getName());
	}

	public function testLabelBeatsText()
	{
		$button = Button::create([
			'label' => 'etichetta',
			'text' => 'testo'
		]);

		$this->assertEquals('etichetta', $button->getName());
	}

	public function testTextBeatsTranslatedText()
	{
		$button = Button::create([
			'text' => 'testo',
			'translatedText' => 'tradotto'
		]);

		$this->assertEquals('testo', $button->getName());
	}

	public function testTranslatedTextUsedWhenAlone()
	{
		$button = Button::create([
			'translatedText' => 'tradotto'
		]);

		$this->assertEquals('tradotto', $button->getName());
	}

	public function testHrefSlugFallback()
	{
		$button = Button::create([
			'href' => 'https://example.com/models/edit'
		]);

		$this->assertEquals(Str::slug('https://example.com/models/edit'), $button->getName());
	}

	public function testRandomNumberAsLastResort()
	{
		$button = Button::create([]);

		$this->assertIsInt($button->name);
		$this->assertGreaterThanOrEqual(0, $button->name);
	}

	public function testNameSlugAppendedToHtmlClasses()
	{
		$button = Button::create([
			'name' => 'Nome Bottone'
		]);

		$this->assertContains('nome-bottone', $button->getHtmlClasses());
		$this->assertContains('uk-button', $button->getHtmlClasses());
	}
}
