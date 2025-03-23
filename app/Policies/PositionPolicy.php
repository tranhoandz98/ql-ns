<?php

namespace App\Policies;

use App\Models\User;

class PositionPolicy
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
        return checkPermission('position_list');
    }

    public function view()
    {
        return checkPermission('position_view');
    }

    public function create()
    {
        return checkPermission('position_create');
    }

    public function update()
    {
        return checkPermission('position_update');
    }

    public function delete()
    {
        return checkPermission('position_delete');
    }
}
