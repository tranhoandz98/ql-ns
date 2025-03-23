<?php

namespace App\Policies;

use App\Models\User;

class TimekeepingPolicy
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
        return checkPermission('timekeeping_list');
    }


    public function create()
    {
        return checkPermission('timekeeping_create');
    }

    public function update()
    {
        return checkPermission('timekeeping_update');
    }

    public function delete()
    {
        return checkPermission('timekeeping_delete');
    }
}
