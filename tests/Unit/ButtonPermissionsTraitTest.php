<?php

use PHPUnit\Framework\TestCase;

class ButtonPermissionsTraitTest extends TestCase
{
    public function testUserCanViewIfNoRolesOrPermissions()
    {
        $button = new class {
            use \IlBronza\Buttons\Traits\ButtonPermissionsTrait;
            public $roles = null;
            public $permissions = null;
        };

        $this->assertTrue($button->userCanView());
    }
}
