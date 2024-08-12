<?php

namespace App\Http\Controllers\Api\Auth\Telegram;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RefreshTokenController extends Controller
{
    private \App\Http\Services\Telegram\AuthService $authService;

    public function __construct()
    {
        $this->authService = new \App\Http\Services\Telegram\AuthService();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $validator = $request->validate(['telegram_id' => 'required:int']);

        $token = $this
            ->authService
            ->getTokenByTelegramId($validator['telegram_id']);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Пользователь не найден'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'token' => $token
        ], 200);
    }
}
