<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Telegram\RegisterRequest;
use App\Http\Services\Telegram\AuthService;
use App\Http\Services\Telegram\UserService;

class RegisterController extends Controller
{
    private AuthService $authService;

    private \App\Http\Services\Telegram\UserService $userService;

    public function __construct()
    {
        $this->authService = new AuthService();
        $this->userService = new UserService();
    }



//    /**
//     * @param RegisterRequest $request
//     * @return mixed
//     */
//    public function register(RegisterRequest $request): mixed
//    {
//        $data = $request->all();
//        $this
//            ->userService
//            ->findByTelegramId($data['telegram_id']);
//
//        if ($this->userService->getUser()) {
//            return response()->json([
//                'status' => 'error',
//                'message' => 'Пользователь уже существует',
//            ]);
//        }
//
//        return response()->json($this->authService->register($data));
//    }
}
