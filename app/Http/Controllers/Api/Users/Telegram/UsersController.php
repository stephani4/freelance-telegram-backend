<?php

namespace App\Http\Controllers\Api\Users\Telegram;

use App\Http\Controllers\Controller;
use App\Http\Services\Telegram\UserService;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param $telegram
     * @return mixed
     */
    public function findByTelegramId(int $telegram): mixed
    {
        $this
            ->userService
            ->findByTelegramId($telegram);

        return response()->json([
            'user' => $this->userService->getUser(),
            'exist' => $this->userService->isExistUser()
        ], 200);
    }
}
