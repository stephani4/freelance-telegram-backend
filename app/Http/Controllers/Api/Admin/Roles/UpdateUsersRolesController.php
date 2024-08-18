<?php

namespace App\Http\Controllers\Api\Admin\Roles;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UpdateUsersRolesController extends Controller
{
    /**
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $data = $request->get('data');
        $this->sync($data);

        return response()->json([
            'message' => 'Роли пользователей успешно изменены.',
            'status' => 'success',
        ], 201);
    }

    /**
     * @param array $data
     * @return void
     */
    private function sync(array $data): void
    {
        foreach ($data as $values) {
            $user = User::find($values['userId']);

            $user->roles()->sync($values['roles']);
        }
    }
}
