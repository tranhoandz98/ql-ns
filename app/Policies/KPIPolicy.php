<?php

namespace App\Policies;

use App\Models\User;

class KPIPolicy
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
        return checkPermission('kpi_list');
    }

    public function view()
    {
        return checkPermission('kpi_view');
    }

    public function create()
    {
        return checkPermission('kpi_create');
    }

    public function update()
    {
        return checkPermission('kpi_update');
    }

    public function delete()
    {
        return checkPermission('kpi_delete');
    }
    public function send()
    {
        return checkPermission('kpi_send');
    }
    public function approve()
    {
        return checkPermission('kpi_approve');
    }
    public function reject()
    {
        return checkPermission('kpi_reject');
    }

}
