<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserFormRequest;
use App\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth:api')->except('store');
    }

    public function store(UserFormRequest $request)
    {
        $user = User::create($request->all());

        return response()->json([
            'message' => 'Registration successful.',
            'user' => $user
        ]);
    }
}
