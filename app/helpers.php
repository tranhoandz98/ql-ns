<?php

use Carbon\Carbon;

if (!function_exists('formatDateTimeView')) {
    function formatDateTimeView($datetime, $format = 'd/m/Y H:i:s')
    {
        if (empty($datetime)){
            return '';
        }
        return Carbon::parse($datetime)->format($format);
    }
}

if (!function_exists('formatDateView')) {
    function formatDateView($datetime, $format = 'd/m/Y')
    {
        if (empty($datetime)){
            return '';
        }
        return Carbon::parse($datetime)->format($format);
    }
}