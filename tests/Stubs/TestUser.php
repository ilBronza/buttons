<?php

namespace IlBronza\Buttons\Tests\Stubs;

use Illuminate\Foundation\Auth\User as Authenticatable;

class TestUser extends Authenticatable
{
	protected $guarded = [];

	public bool $superAdmin = false;
	public array $userRoles = [];

	public function isSuperAdmin() : bool
	{
		return $this->superAdmin;
	}

	public function hasAnyRole(array $roles) : bool
	{
		return count(array_intersect($roles, $this->userRoles)) > 0;
	}
}
