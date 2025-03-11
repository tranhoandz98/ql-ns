<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'user_role';
    protected $guarded = [];
    public $timestamps = false;

    public function dataRole(){
        return $this->belongsTo('App\Role','role_id','id');
    }
}
