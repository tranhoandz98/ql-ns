<?php

namespace App\Models;

use App\Enums\User\StatusGlobalEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Departments extends Model
{
    //
    protected $table = 'departments';
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

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id', 'id',);
    }

    public function scopeActive($query)
    {
        return $query->where('status', StatusGlobalEnum::HOAT_DONG->value);
    }
}
