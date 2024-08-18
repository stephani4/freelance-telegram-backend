<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Services\Telegram\UserService;
use Illuminate\Http\Request;

class UpdateUserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function update(Request $request)
    {
        $user = auth('api')->user();
    }
}
