<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $connection = 'main';
    protected $table = 'users';
    public $primaryKey = "username";
    public $incrementing  = false;
    protected $guarded = [];
    protected $hidden = ['password'];

}
