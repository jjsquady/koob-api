<?php
/**
 * Created by PhpStorm.
 * User: jjsquady
 * Date: 5/7/18
 * Time: 9:18 AM
 */

namespace App\Traits;

trait LatestLogin
{
    protected $relatedKey = 'user_id';

    public function logins()
    {
        return $this->hasMany($this->loginClass);
    }

    /**
     * @throws \Exception
     */
    protected function getLoginClass()
    {
        if (!property_exists($this, 'loginClass')) {
            throw new \Exception('Set loginClass property on this model.');
        }

        return $this->loginClass;
    }

    protected function getLoginKey()
    {
        return 'login_at';
    }

    protected function getRelationKey()
    {
        return $this->relatedKey;
    }

    public function getLatestLoginAttribute()
    {
        if(!class_exists($this->loginClass)) {
            return null;
        }

        $loginDate = optional(
            optional(
                app($this->loginClass)
                    ->where($this->getRelationKey(), $this->getKey())
                    ->get()
                    ->take(-2)
                    ->first()
            )->{$this->getLoginKey()}
        );

        $latestLogin = (!is_null($loginDate))
            ? optional($loginDate)->toDateTimeString()
            : null;

        return $latestLogin;
    }
}