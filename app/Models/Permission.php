<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    private static $permission;


    protected $table = 'permission';
    protected $guarded = [];

    public static function singletonListPermission()
    {
        if (!self::$permission) {
            self::$permission = Permission::all();
        }
        return self::$permission;
    }
}
