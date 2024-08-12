<?php

namespace App\Http\Controllers\Api\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Services\Telegram\TaskService;
use Illuminate\Http\Request;

class MyTasksController extends Controller
{
    private TaskService $taskService;

    public function __construct()
    {
        $this->taskService = new TaskService();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function my(Request $request): mixed
    {
        $tasks = $this->taskService->getTasksByFilter(array_merge(
            $request->all(),
            $this->getFilters()
        ));

        return response()->json([
            'status' => 'success',
            'tasks' => $tasks
        ]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function show(Request $request, int $id)
    {
        $user = auth('api')->user();
        $task = $this->taskService->findById($id);

        if (!$task) {
            return response()->json([
                'status' => 'not-found-task',
                'message' => 'Не доступа'
            ], 404);
        }

        if ($task->user_id !== $user->id) {
            return response()->json([
                'status' => 'access-denied-task',
                'message' => 'У вас нет доступа к просмотру задачи'
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'task' => $task,
        ], 200);
    }

    /**
     * @return array
     */
    private function getFilters() : array
    {
        $user = auth('api')->user();

        return [
            'user' => $user->id,
            'order_by_desc' => "id"
        ];
    }
}
