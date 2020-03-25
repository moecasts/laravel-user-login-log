<?php

namespace Moecasts\Laravel\UserLoginLog\Test\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Moecasts\Laravel\UserLoginLog\Traits\LoginLoggable;

class User extends Authenticatable
{
    use LoginLoggable;

    protected $table = 'users';

    protected $fillable = [
        'name',
    ];
}
