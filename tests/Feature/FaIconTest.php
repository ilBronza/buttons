<?php

namespace IlBronza\Buttons\Tests\Feature;

use IlBronza\Buttons\Icons\FaIcon;
use IlBronza\Buttons\Tests\TestCase;

class FaIconTest extends TestCase
{
	public function testCheckRendersSuccessClass()
	{
		$html = FaIcon::check();

		$this->assertStringContainsString('uk-text-success', $html);
		$this->assertStringContainsString('fa-check', $html);
	}

	public function testXmarkRendersDangerClass()
	{
		$html = FaIcon::xmark();

		$this->assertStringContainsString('uk-text-danger', $html);
		$this->assertStringContainsString('fa-xmark', $html);
	}

	public function testInlineRendersGivenCode()
	{
		$this->assertStringContainsString('fa-edit', FaIcon::inline('edit'));
	}

	public function testFillingTypeComesFromConfig()
	{
		$this->assertStringContainsString('fa-solid', FaIcon::inline('pen'));

		config(['buttons.faIcons.fillingType' => 'regular']);

		$this->assertStringContainsString('fa-regular', FaIcon::inline('pen'));
	}

	public function testExplicitFillingTypeWinsOverConfig()
	{
		$icon = FaIcon::create([
			'code' => 'pen',
			'fillingType' => 'light'
		]);

		$this->assertStringContainsString('fa-light', $icon->render());
	}

	public function testEmailShortcutUsesEnvelope()
	{
		$this->assertStringContainsString('fa-envelope', FaIcon::email());
	}
}
