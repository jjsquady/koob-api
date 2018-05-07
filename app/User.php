<?php

namespace App;

use App\Traits\LatestLogin;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use YourAppRocks\EloquentUuid\Traits\HasUuid;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasUuid, LatestLogin;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['latest_login'];

    protected $loginClass = Login::class;

    public function getKeyType()
    {
        return 'string';
    }

    public function getUuidColumnName()
    {
        return 'id';
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'user' => [
                'id'         => $this->getKey(),
                'name'         => $this->name,
                'latest_login' => $this->latest_login,
            ]
        ];
    }
}
