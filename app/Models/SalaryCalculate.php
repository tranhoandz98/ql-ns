<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SalaryCalculate extends Model
{
    //
    protected $table = 'salary_calculate';
    protected $guarded = [];

    const ADD ='ADD';
    const SUB ='SUB';

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

}
