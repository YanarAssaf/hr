<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $fillable = ['name','year','days'];

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
