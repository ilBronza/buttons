<?php

namespace IlBronza\Buttons\Traits;

use Auth;
use Illuminate\Support\Str;

trait ButtonPermissionsTrait
{
    /**
     * Check if the button has roles defined.
     *
     * @return bool
     */
    public function hasRoles()
    {
        if(! $this->roles)
            return false;

        if(count($this->roles) == 0)
            return false;

        return true;
    }

    /**
     * Get the roles assigned to the button.
     *
     * @return array|null
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Check if the button has permissions defined.
     *
     * @return bool
     */
    public function hasPermissions()
    {
        if(! $this->permissions)
            return false;

        if(count($this->permissions) == 0)
            return false;

        return true;
    }

    /**
     * Get the permissions assigned to the button.
     *
     * @return array|null
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * Check if the currently authenticated user can view the button.
     *
     * @return bool
     */
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