<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteSettings extends Model
{

    protected $guarded = [];

    public static function in_maintenance () {
        if (self::where('name', 'maintenance')->first()->value == 1) {
            return true;
        }
        return false;
    }
}
