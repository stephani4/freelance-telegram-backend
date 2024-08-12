<?php

namespace App\Http\Controllers\Api\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Telegram\Tasks\CreateTaskRequest;
use App\Http\Services\Telegram\TaskService;

class CreateTaskController extends Controller
{
    private TaskService $taskService;

    public function __construct()
    {
        $this->taskService = new TaskService();
    }

    /**
     * @param CreateTaskRequest $request
     * @return mixed
     */
    public function create(CreateTaskRequest $request): mixed
    {
        $taskID = $this->taskService->create(
            auth('api')->user()->id,
            $request->all()
        );

        return response()->json([
            'status'    => 'success',
            'message'   => 'Задача успешно создана',
            'task'      => $taskID,
        ]);
    }
}
