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


if (!function_exists('getDayOfMonth')) {
    function getDayOfMonth()
    {

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $totalDays = 0;

        // Lặp qua từng ngày trong tháng
        for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
            if (!in_array($date->dayOfWeek, [6, 0])) { // 6: Thứ Bảy, 0: Chủ Nhật
                $totalDays++;
            }
        }

        return $totalDays;
    }
}

if (!function_exists('formatCurrency')) {
    function formatCurrency($number)
    {
        // Loại bỏ tất cả ký tự không phải số
        $number = preg_replace('/\D/', '', $number);

        // Định dạng số theo kiểu tiền tệ Việt Nam (VND)
        return number_format($number, 0, ',', '.');
    }
}
