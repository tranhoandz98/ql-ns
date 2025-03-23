<?php

use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

if (!function_exists('formatDateTimeView')) {
    function formatDateTimeView($datetime, $format = 'd/m/Y H:i:s')
    {
        if (empty($datetime)) {
            return '';
        }
        return Carbon::parse($datetime)->format($format);
    }
}

if (!function_exists('formatDateView')) {
    function formatDateView($datetime, $format = 'd/m/Y')
    {
        if (empty($datetime)) {
            return '';
        }
        return Carbon::parse($datetime)->format($format);
    }
}

if (!function_exists('checkPermission')) {
    function checkPermission($permission)
    {
        $permission = Permission::singletonListPermission()->where('name', $permission)->first();
        if (!$permission) {
            return false;
        }

        $role = Auth::user()->role;
        $rolePermission = $role->getPermissionSingleton();
        return $rolePermission->where('id', $permission->id)->first() ? true : false;
    }
}
