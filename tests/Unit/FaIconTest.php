<?php

use IlBronza\Buttons\Icons\FaIcon;
use PHPUnit\Framework\TestCase;

class FaIconTest extends TestCase
{
    public function testCheckRendersSuccessClass()
    {
        $html = FaIcon::check();
        $this->assertStringContainsString('uk-text-success', $html);
    }

    public function testXmarkRendersDangerClass()
    {
        $html = FaIcon::xmark();
        $this->assertStringContainsString('uk-text-danger', $html);
    }

    public function testInlineRendersGivenCode()
    {
        $html = FaIcon::inline('edit');
        $this->assertStringContainsString('edit', $html);
    }
}
