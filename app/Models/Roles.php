<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Roles extends Model
{
    //
    protected $table = 'roles';
    protected $guarded = [];


    private $rolePermission;

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

    public function getPermissionSingleton()
    {
        if (!$this->rolePermission) {
            $this->rolePermission = $this->rolePermission()->get();
        }
        return $this->rolePermission;
    }

    public function rolePermission()
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'role_id', 'permission_id');
    }
}
