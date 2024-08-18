<?php

namespace App\Http\Controllers\Api\Auth\Telegram;

use App\Http\Controllers\Controller;
use App\Http\Services\Telegram\AuthService;
use App\Http\Services\Telegram\UserService;
use Illuminate\Http\Request;

class CheckLoginController extends Controller
{
    /**
     * @var AuthService
     */
    private AuthService $authService;

    /**
     * @var UserService
     */
    private UserService $userService;

    public function __construct()
    {
        $this->authService = new AuthService();

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
        $data = $request->all();
        $webAppInitData = $data['web_app_init_data'];

        // Преобразуем query string в массив
        $variables = [];
        parse_str($webAppInitData, $variables);
        $variables = (object)$variables;

        $user = is_string($variables->user) && strlen($variables->user) > 0
            ? json_decode($variables->user)
            : null;

        if (!$user)
            return response()->json(['error' => 'Отсутвует пользователь в строке идентификации'], 403);

        $this
            ->userService
            ->findByTelegramId($user->id);

        if (!$this->userService->getUser()) {
            return response()->json([
                'exist' => false,
                'user' => null,
            ], 200);
        }

        $token = $this->authService->getTokenByTelegramId($user->id);
        $user = $this->userService->getUser()->user;

        return response()->json([
            'exist' => true,
            'token' => $token,
            'user' => $user,
        ], 200);
    }
}
