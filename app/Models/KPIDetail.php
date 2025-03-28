<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class KPIDetail extends Model
{
    //
    protected $table = 'kpi_details';
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

    public function kpi()
    {
        return $this->belongsTo(KPI::class, 'kpi_id', 'id',);
    }

}
