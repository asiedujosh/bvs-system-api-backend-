<?php

if (!function_exists('checkExpiryDate')) {
    function checkExpiryDate($dateString)
    {
        $currentDate = \Carbon\Carbon::now();
        $expiryDate = \Carbon\Carbon::parse($dateString);

        return $currentDate->lt($expiryDate);
    }
}
