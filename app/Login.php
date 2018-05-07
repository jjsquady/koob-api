<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;

class Login extends Model
{
    use HasUuid;

    public $timestamps = false;

    protected $fillable = ['user_id', 'login_at', 'ip', 'user_agent'];

    protected $dates = ['login_at'];

    public function getKeyType()
    {
        return 'string';
    }

    public function getUuidColumnName()
    {
        return 'id';
    }
}
