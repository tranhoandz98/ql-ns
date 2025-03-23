<?php

namespace App\Policies;

use App\Models\User;

class DepartmentPolicy
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
        return checkPermission('department_list');
    }

    public function view()
    {
        return checkPermission('department_view');
    }

    public function create()
    {
        return checkPermission('department_create');
    }

    public function update()
    {
        return checkPermission('department_update');
    }

    public function delete()
    {
        return checkPermission('department_delete');
    }
}
