<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Salary extends Model
{
    //
    protected $table = 'salary';
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
    public function details()
    {
        return $this->hasMany(SalaryDetails::class, 'salary_id', 'id',);
    }
    public function calculates()
    {
        return $this->hasMany(SalaryCalculate::class, 'salary_id', 'id',);
    }

}
