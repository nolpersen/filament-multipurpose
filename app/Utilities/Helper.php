<?php

namespace App\Utilities;

use App\Models\Setting;

class Helper
{
    public static function get_setting($name){
        $setting = Setting::where('name', $name)->first();
        return $setting;
    }
}
