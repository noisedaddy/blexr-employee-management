<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Notification extends Model
{
    protected $table = 'notifications';
    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            if(\Auth::check()) {
                $user = \Auth::user();
                $model->created_by = $user->email;
                $model->updated_by = $user->email;
            }
        });
        static::updating(function($model)
        {
            if(\Auth::check()) {
                $user = \Auth::user();
                $model->updated_by = $user->email;
            }
        });
    }

    public function ship(){
        $this->belongsTo(Ship::class);
    }

    public function roles(){
        $this->belongsTo(Role::class);
    }
}
