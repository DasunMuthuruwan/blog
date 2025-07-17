<?php

/**
 * Site information
 */

use App\Models\GeneralSetting;

if (!function_exists('settings')) {
    function settings()
    {
        $settings = GeneralSetting::first();

        if ($settings) {
            return $settings;
        }
    }
}
