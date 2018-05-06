<?php
/**
 * Created by PhpStorm.
 * User: jjsquady
 * Date: 5/6/18
 * Time: 2:04 AM
 */

namespace App\Observers;


use Illuminate\Support\Facades\Hash;

class UserObserver
{
    public function creating($user)
    {
        $user->password = Hash::make($user->password);
    }
}