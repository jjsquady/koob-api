<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use YourAppRocks\EloquentUuid\Traits\HasUuid;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasUuid;

    protected $keyType = 'string';

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

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getAttribute('uuid');
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
                'name'         => $this->name,
                'latest_login' => $this->latest_login,
                'uuid'         => $this->uuid
            ]
        ];
    }

    public function logins()
    {
        return $this->hasMany(Login::class);
    }

    public function getLatestLoginAttribute()
    {
        $latestLogin = optional(
            optional(Login::where('user_uuid', $this->uuid)->get()->take(-2)->first())->login_at
        )->toDateTimeString();
        return $latestLogin;
    }
}
