<?php

namespace App\Http\Controllers\Api\Admin\Telegram\Tasks;

use App\Enums\TaskStatus;
use App\Http\Controllers\Controller;
use App\Http\Services\Telegram\TaskService;
use Illuminate\Http\Request;

class ChangeStatusTaskController extends Controller
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function change(Request $request, int $id): mixed
    {
        $data = $request->validate(['status' => 'required|string']);

        $task = $this->taskService->findById($id);
        if (!$task)
            return response()->json([
                'status' => 'error',
                'message' => 'Status not found',
            ], 404);

        if (method_exists($this, $data['status'])) {
            $this->{$data['status']}($id);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Статус успешно изменен'
        ], 201);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    private function accept(int $id)
    {
        $this->taskService->changeStatus($id, TaskStatus::ACCEPT->value, [
            'moderator_id' => auth('api')->user()->id,
            'moderated_at' => date('Y-m-d H:i:s')
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Задание принято модератором'
        ], 200);
    }
}
