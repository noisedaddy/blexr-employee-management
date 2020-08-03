<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{
    protected $fillable = ['name'];


    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            if(\Auth::check()) {
                $user = \Auth::user();
                $model->created_by = $user->email;
                $model->updated_by = $user->email;
                $model->serial_number = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 8);;
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

    public function user() {
        return $this->hasMany(User::class);
    }

}
