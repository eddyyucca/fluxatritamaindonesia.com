<?php

use Illuminate\Support\Facades\Cache;
use Modules\Setting\Models\Setting;

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        $settings = Cache::rememberForever('app_settings', function () {
            return Setting::all()->pluck('value', 'key')->toArray();
        });

        $value = $settings[$key] ?? $default;

        // Try to decode json if possible
        if (is_string($value) && is_array(json_decode($value, true)) && (json_last_error() == JSON_ERROR_NONE)) {
            return json_decode($value, true);
        }

        return $value;
    }
}
