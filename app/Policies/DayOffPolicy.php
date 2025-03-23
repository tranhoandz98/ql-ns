<?php

namespace App\Policies;

use App\Models\User;

class DayOffPolicy
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
        return checkPermission('day_off_list');
    }

    public function view()
    {
        return checkPermission('day_off_view');
    }

    public function create()
    {
        return checkPermission('day_off_create');
    }

    public function update()
    {
        return checkPermission('day_off_update');
    }

    public function delete()
    {
        return checkPermission('day_off_delete');
    }
    public function send()
    {
        return checkPermission('day_off_send');
    }
    public function approve()
    {
        return checkPermission('day_off_approve');
    }
    public function reject()
    {
        return checkPermission('day_off_reject');
    }
    public function allocation()
    {
        return checkPermission('day_off_allocation');
    }

}
