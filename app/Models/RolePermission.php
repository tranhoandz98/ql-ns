<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    //
    public $timestamps = false;
    protected $table = 'role_permission';
    protected $guarded = [];

    public function dataPermission(){
        return $this->belongsTo('App\Models\Permission','permission_id','id');
    }
}
