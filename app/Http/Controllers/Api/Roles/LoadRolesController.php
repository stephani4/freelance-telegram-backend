<?php

namespace App\Http\Controllers\Api\Roles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class LoadRolesController extends Controller
{
    /**
     * @return mixed
     */
    public function load()
    {
        $roles = Role::all();
        return response()->json($roles, 200);
    }
}
