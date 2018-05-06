<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'login_at', 'ip', 'user_agent'];

    protected $dates = ['login_at'];
}
