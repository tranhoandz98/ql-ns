<?php

namespace App\Policies;

use App\Models\User;

class SalaryPolicy
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
        return checkPermission('salary_list');
    }

    public function view()
    {
        return checkPermission('salary_view');
    }

    public function create()
    {
        return checkPermission('salary_create');
    }

    public function update()
    {
        return checkPermission('salary_update');
    }

    public function delete()
    {
        return checkPermission('salary_delete');
    }
    public function approve()
    {
        return checkPermission('salary_approve');
    }

}
