<?php

namespace App\Http\Controllers\Api\Admin\Telegram\Users;

use App\Http\Controllers\Controller;
use App\Http\Services\Telegram\UserService;
use Illuminate\Http\Request;

class LoadUsersController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     * @return void
     */
    public function load(Request $request)
    {
        return response()->json(
            $this->userService->filtered($request->all()),
            200
        );
    }
}
