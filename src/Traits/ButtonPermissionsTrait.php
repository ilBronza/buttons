<?php

namespace IlBronza\Buttons\Traits;

use Auth;
use Illuminate\Support\Str;

trait ButtonPermissionsTrait
{
    public function hasRoles()
    {
        if(! $this->roles)
            return false;

        if(count($this->roles) == 0)
            return false;

        return true;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function hasPermissions()
    {
        if(! $this->permissions)
            return false;

        if(count($this->permissions) == 0)
            return false;

        return true;
    }

    public function getPermissions()
    {
        return $this->permissions;
    }

    public function userCanView() : bool
    {
        if((! $this->hasRoles())&&(! $this->hasPermissions()))
            return true;

        if(! $user = Auth::user())
            return false;

        if($user->isSuperAdmin())
            return true;

        if(($this->getRoles())&&($user->hasAnyRole($this->getRoles())))
            return true;

        if(($this->getPermissions())&&($user->hasAnyPermission($this->getPermissions())))
            return true;

        return false;
    }
}