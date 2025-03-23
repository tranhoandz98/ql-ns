<?php

namespace App\Policies;

use App\Models\User;

class OvertimePolicy
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
        return checkPermission('overtime_list');
    }

    public function view()
    {
        return checkPermission('overtime_view');
    }

    public function create()
    {
        return checkPermission('overtime_create');
    }

    public function update()
    {
        return checkPermission('overtime_update');
    }

    public function delete()
    {
        return checkPermission('overtime_delete');
    }
    public function send()
    {
        return checkPermission('overtime_send');
    }
    public function approve()
    {
        return checkPermission('overtime_approve');
    }
    public function reject()
    {
        return checkPermission('overtime_reject');
    }
}
