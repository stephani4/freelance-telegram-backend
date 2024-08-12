<?php

namespace App\Http\Controllers\Api\Auth\Telegram;

use App\Http\Controllers\Controller;
use App\Http\Services\Telegram\AuthService;
use App\Http\Services\Telegram\UserService;
use Illuminate\Http\Request;

class CheckLoginController extends Controller
{
    /**
     * @var \App\Http\Services\Telegram\AuthService
     */
    private AuthService $authService;

    /**
     * @var UserService
     */
    private UserService $userService;

    public function __construct()
    {
        $this->authService = new \App\Http\Services\Telegram\AuthService();
        $this->userService = new UserService();
    }

    /**
     * Проверка пользователя на существование
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request): mixed
    {
        $user = auth('api')->user();

        $this
            ->userService
            ->find($user->id);

        if (!$this->userService->getUser()) {
            return response()->json([
                'exist' => false,
                'user' => null,
            ], 200);
        }

        $user = $this->userService->getUser();
        $roles = $user->roles;

        $user = $user->toArray();
        $user['roles'] = $roles;

        return response()->json([
            'exist' => true,
            'user' => $this->userService->getUser()
        ], 200);
    }
}
