<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Services\Telegram\UserService;
use Illuminate\Http\Request;

class UpdateProfileController extends Controller
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request)
    {
        $user = auth('api')->user();
        $this->userService->update($user, $request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Профиль успешно обновлен'
        ]);
    }
}
