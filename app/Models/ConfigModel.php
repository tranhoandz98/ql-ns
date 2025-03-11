<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ConfigModel extends Model
{
    //
    protected $table = 'config';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::id();
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }

    // get setting by key
    public static function getSetting($key)
    {
        return self::getModelSetting()->$key;
    }

    public static function getModelSetting()
    {
        $settingSecond = ConfigModel::query()->pluck('value', 'key')->all();
        $setting = (object) $settingSecond;
        return $setting;
    }
}
