<?php

namespace App\Http\Controllers\Api\Admin\Telegram\Tasks;

use App\Enums\TaskStatus;
use App\Http\Controllers\Controller;
use App\Http\Services\Telegram\TaskService;

class ModerateTasksController extends Controller
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * @return mixed
     */
    public function moderates(): mixed
    {
        $tasks = $this->taskService->getTasksByFilter([
            'status' => TaskStatus::MODERATE->value
        ]);

        return response()->json([
            'status' => 'success',
            'tasks' => $tasks
        ], 200);
    }
}
