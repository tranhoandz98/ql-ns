<?php

namespace App\Policies;

use App\Models\User;

class RolePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny()
    {
        return checkPermission('role_list');
    }

    public function view()
    {
        return checkPermission('role_view');
    }

    public function create()
    {
        return checkPermission('role_create');
    }

    public function update()
    {
        return checkPermission('role_update');
    }

    public function delete()
    {
        return checkPermission('role_delete');
    }
}
