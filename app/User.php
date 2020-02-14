<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'department_id', 'is_manager', 'balance_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function leaves()
    {
        return $this->hasMany('App\Leave')->latest();
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function balance()
    {
        return $this-> belongsTo ( 'App\Balance' )-> withDefault ( [
            'year'  => '1991',
            'days'  => '0'
            ] ) ;
    }
}
