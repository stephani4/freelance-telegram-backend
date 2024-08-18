<?php

namespace App\Http\Controllers\Api\Tasks;

use App\Enums\Roles;
use App\Http\Controllers\Controller;
use App\Http\Requests\Telegram\Tasks\CreateTaskRequest;
use App\Http\Services\Telegram\TaskService;
use App\Models\User;
use Illuminate\Notifications\Notification;

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
        $task = $this->taskService->create(
            auth('api')->user()->id,
            $request->all()
        );

        $users = User::role(Roles::TASK_MODERATOR->value)
            ->with('resource')
            ->get();

        foreach ($users as $user) {
            \Illuminate\Support\Facades\Notification::send($user, new \App\Notifications\TaskModeratingNotice(
                $task,
                $user
            ));
        }

        return response()->json([
            'status'    => 'success',
            'message'   => 'Задача успешно создана',
            'task'      => $task->id,
        ]);
    }
}
