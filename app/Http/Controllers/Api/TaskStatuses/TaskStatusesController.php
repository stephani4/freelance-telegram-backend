<?php

namespace App\Http\Controllers\Api\TaskStatuses;

use App\Http\Controllers\Controller;
use App\Models\Task;

class TaskStatusesController extends Controller
{
    public function all()
    {
        return response()->json([
           'status' => 'success',
           'statuses' => Task::getStatuses()
        ]);
    }
}
