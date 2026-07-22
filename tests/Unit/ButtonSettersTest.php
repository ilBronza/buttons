<?php

namespace IlBronza\Buttons\Tests\Unit;

use IlBronza\Buttons\Button;
use IlBronza\Buttons\Tests\TestCase;

class ButtonSettersTest extends TestCase
{
	private function button(array $parameters = []) : Button
	{
		return Button::create($parameters + ['name' => 'test']);
	}

	public function testFluentSettersReturnStatic()
	{
		$button = $this->button();

		$this->assertSame($button, $button->setPrimary());
		$this->assertSame($button, $button->setSecondary());
		$this->assertSame($button, $button->setDanger());
		$this->assertSame($button, $button->setSmall());
		$this->assertSame($button, $button->setHtmlClass('custom'));
		$this->assertSame($button, $button->setDisabled());
		$this->assertSame($button, $button->setSubmit());
		$this->assertSame($button, $button->addData(['a' => 'b']));
		$this->assertSame($button, $button->setData('c', 'd'));
		$this->assertSame($button, $button->tooltip('suggerimento'));
		$this->assertSame($button, $button->setAsIframe());
		$this->assertSame($button, $button->setShowText(false));
	}

	public function testStyleClassesAreAdded()
	{
		$button = $this->button();

		$button->setPrimary();
		$button->setDanger();
		$button->setSmall();
		$button->setHtmlClass('mia-classe');
		$button->addClass('altra-classe');

		$classes = $button->getHtmlClasses();

		$this->assertContains('uk-button-primary', $classes);
		$this->assertContains('uk-button-danger', $classes);
		$this->assertContains('uk-button-small', $classes);
		$this->assertContains('mia-classe', $classes);
		$this->assertContains('altra-classe', $classes);
	}

	public function testRemoveButtonHtmlClass()
	{
		$button = $this->button();

		$button->removeButtonHtmlClass('uk-button');

		$this->assertNotContains('uk-button', $button->getHtmlClasses());
	}

	public function testDisabled()
	{
		$button = $this->button();

		$this->assertFalse($button->isDisabled());

		$button->setDisabled();

		$this->assertTrue($button->isDisabled());

		$button->setDisabled(false);

		$this->assertFalse($button->isDisabled());
	}

	public function testDataHandling()
	{
		$button = $this->button();

		$button->addData(['uno' => 1, 'due' => 2]);
		$button->setData('tre', 3);

		$this->assertEquals(['uno' => 1, 'due' => 2, 'tre' => 3], $button->getData());
	}

	public function testTargetAndBlank()
	{
		$button = $this->button();

		$this->assertNull($button->getTarget());
		$this->assertFalse($button->hasTargetBlank());

		$button->setBlank();

		$this->assertEquals('_blank', $button->getTarget());
		$this->assertTrue($button->hasTargetBlank());
	}

	public function testSubmitSetsDataAndDefaultValue()
	{
		$button = $this->button();

		$this->assertFalse($button->isSubmit());

		$button->setSubmit();

		$this->assertTrue($button->isSubmit());
		$this->assertEquals(1, $button->getValue());
		$this->assertTrue($button->getData()['submit']);
	}

	public function testSubmitKeepsExistingValue()
	{
		$button = $this->button(['value' => 'salva']);

		$button->setSubmit();

		$this->assertEquals('salva', $button->getValue());
	}

	public function testReturnConfirm()
	{
		$button = $this->button();

		$this->assertFalse($button->hasReturnConfirm());

		$button->setReturnConfirm('Sei sicuro?');

		$this->assertTrue($button->hasReturnConfirm());
		$this->assertEquals('Sei sicuro?', $button->getReturnConfirmText());
	}

	public function testIframe()
	{
		$button = $this->button();

		$this->assertFalse($button->isIframe());

		$button->setAsIframe();

		$this->assertTrue($button->isIframe());
		$this->assertTrue($button->getData()['openiframe']);
	}

	public function testLightbox()
	{
		$button = $this->button();

		$this->assertFalse($button->hasLightbox());

		$button->setAsLightbox();

		$this->assertTrue($button->hasLightbox());
	}

	public function testToggle()
	{
		$button = $this->button();

		$button->setToggle('elemento');
		$this->assertEquals('#elemento', $button->getToggle());

		$button->setToggleClass('classe');
		$this->assertEquals('.classe', $button->getToggle());
	}

	// regression: il metodo si chiama haasValue(), refuso incluso.
	// se questo test fallisce qualcuno l'ha rinominato: serve un alias
	public function testHaasValueTypoRegression()
	{
		$button = $this->button();

		$this->assertFalse($button->haasValue());

		$button->value = 'x';

		$this->assertTrue($button->haasValue());
	}

	public function testSetAttribute()
	{
		$button = $this->button();

		$button->setAttribute('rel', 'nofollow');

		$this->assertEquals(['rel' => 'nofollow'], $button->getAttributes());
	}

	public function testAjaxTableButton()
	{
		$button = $this->button(['href' => 'https://example.com/action']);

		$button->setAjaxTableButton('.mia-tabella', ['extra' => 'valore']);

		$this->assertTrue($button->isAjaxButton());
		$this->assertContains('ib-table-action-button', $button->getHtmlClasses());
		$this->assertEquals('https://example.com/action', $button->getData()['route']);
		$this->assertEquals('.mia-tabella', $button->getData()['table']);
		$this->assertEquals('valore', $button->getData()['extra']);
	}

	public function testSubmitTableButtonSetsRedirectSubmit()
	{
		$button = $this->button(['href' => 'https://example.com/action']);

		$button->setSubmitTableButton();

		$this->assertTrue($button->getData()['redirectsubmit']);
		$this->assertEquals('.datatable', $button->getData()['table']);
	}
}
