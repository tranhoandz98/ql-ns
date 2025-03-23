<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
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
        return checkPermission('user_list');
    }

    public function view()
    {
        return checkPermission('user_view');
    }

    public function create()
    {
        return checkPermission('user_create');
    }

    public function update()
    {
        return checkPermission('user_update');
    }

    public function delete()
    {
        return checkPermission('user_delete');
    }
}
