<?php
namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Hash;

/**
 * Class User
 *
 * @package App
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
*/
class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

//    protected $casts = [
//        'ship_id' => 'array',
//    ];

    protected $fillable = ['name', 'email', 'password', 'ship_id' ,'remember_token'];

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
    /**
     * Hash password
     * @param $input
     */
    public function setPasswordAttribute($input)
    {
        if ($input)
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
    }
    
    
    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function ship() {
        return $this->belongsTo(Ship::class);
    }
    
    
}
