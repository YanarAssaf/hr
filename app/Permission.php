<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['route'];

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
}
