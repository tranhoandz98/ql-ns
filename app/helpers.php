<?php

use Carbon\Carbon;

if (!function_exists('formatDateTimeView')) {
    function formatDateTimeView($datetime, $format = 'd/m/Y H:i:s')
    {
        return Carbon::parse($datetime)->format($format);
    }
}
