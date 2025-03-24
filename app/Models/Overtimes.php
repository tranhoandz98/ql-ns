<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Overtimes extends Model
{
    //
    protected $table = 'overtimes';
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

    public function createdByData()
    {
        return $this->belongsTo(User::class, 'created_by', 'id',);
    }
    public function updatedByData()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id',);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id',);
    }

    public function getIsApproveAttribute()
    {
        $user = User::find($this->user_id);

        $auth = Auth::user();
        if ($user) {
            if ($auth->type == 2 && $user->manager_id == $auth->id) {
                return true;
            } elseif ($auth->type == 1) {
                return true;
            } elseif ($auth->type == 3) {
                return false;
            }
        }

        return null; // hoặc false, tùy thuộc vào logic của bạn
    }
}
