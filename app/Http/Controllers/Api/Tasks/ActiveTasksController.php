<?php

namespace App\Http\Controllers\Api\Tasks;

use App\Enums\TaskStatus;
use App\Http\Controllers\Controller;
use App\Http\Services\Telegram\TaskService;
use Illuminate\Http\Request;

class ActiveTasksController extends Controller
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request): mixed
    {
        $filters = array_merge(self::getDefaultFilterState(), $request->all());
        $tasks = $this->taskService->getTasksByFilter($filters);
        return response()->json($tasks, 200);
    }

    /**
     * @return array
     */
    public static function getDefaultFilterState() : array
    {
        return [
            'status' => TaskStatus::ACCEPT->value
        ];
    }
}
