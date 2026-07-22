<?php

namespace IlBronza\Buttons\Tests\Feature;

use IlBronza\Buttons\Button;
use IlBronza\Buttons\Tests\Stubs\TestUser;
use IlBronza\Buttons\Tests\TestCase;

class ButtonRolesRenderTest extends TestCase
{
	private function button(array $roles = []) : Button
	{
		$button = Button::create([
			'name' => 'protetto',
			'href' => 'https://example.com'
		]);

		$button->roles = $roles;

		return $button;
	}

	public function testButtonWithoutRolesRendersForGuests()
	{
		$this->assertNotNull($this->button()->render());
	}

	public function testButtonWithRolesReturnsNullForGuests()
	{
		$this->assertNull($this->button(['admin'])->render());
	}

	public function testButtonRendersForUserWithMatchingRole()
	{
		$user = new TestUser();
		$user->userRoles = ['admin'];

		$this->be($user);

		$this->assertNotNull($this->button(['admin'])->render());
	}

	public function testButtonReturnsNullForUserWithoutMatchingRole()
	{
		$user = new TestUser();
		$user->userRoles = ['editor'];

		$this->be($user);

		$this->assertNull($this->button(['admin'])->render());
	}

	public function testSuperAdminAlwaysSeesTheButton()
	{
		$user = new TestUser();
		$user->superAdmin = true;

		$this->be($user);

		$this->assertNotNull($this->button(['admin'])->render());
	}
}
