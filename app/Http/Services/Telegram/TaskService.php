<?php

namespace App\Http\Services\Telegram;

use App\Enums\FolderType;
use App\Enums\TaskStatus;
use App\Models\Files;
use App\Models\Task;

class TaskService
{
    const PER_PAGE = 10;

    private Task $task;

    public function __construct()
    {
        $this->task = new Task();
    }

    /**
     * @param array $filter
     * @return mixed
     */
    public function countTasksByFilter(array $filter = []): mixed
    {
        if (!empty($filter['date_from'])) {
            $this->task->where('created_at', '>=', $filter['date_from']);
        }

        if (!empty($filter['date_to'])) {
            $this->task->where('created_at', '<=', $filter['date_to']);
        }

        return $this->task->count();
    }

    /**
     * @param int $userID
     * @param array $data
     * @return Task
     */
    public function create(int $userID, array $data): Task
    {
        $task = $this->taskInstance(array_merge($data, [
            'user_id' => $userID,
            'status' => TaskStatus::MODERATE->value
        ]));

        $task->save();

        $attachingFiles = [];
        foreach ($data['files'] as $file) {
            $attachingFiles[$file['id']] = [
                'side' => 'app',
            ];
        }

        $task->files()->attach($attachingFiles);

        // Переносим изображение в папку "Стабильные"
        if (is_array($data['files'])) {
            foreach ($data['files'] as $file) {
                Files::movedToFolder(
                    Files::find($file['id']),
                    FolderType::STABLE->value
                );
            }
        }

        return $task;
    }

    /**
     * @param array $filters
     * @return mixed
     */
    public function getTasksByFilter(array $filters = []): mixed
    {
        return Task::filter($filters)
            ->with(['files', 'user' => function ($query) {
                return $query->withCount('tasks');
            }, 'serviceCategory' => function ($query) {
                return $query->with(['ancestors' => function ($query) {
                    return $query->where('parent_id', '!=', 0);
                }]);
            }])
            ->paginate(self::PER_PAGE);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findById(int $id): mixed
    {
        return Task::find($id);
    }

    /**
     * @param array $fill
     * @return Task
     */
    public function taskInstance(array $fill = []): Task
    {
        return (new Task())->fill($fill);
    }

    /**
     * @param int $id
     * @param string $status
     * @param array $fillable
     * @return void
     */
    public function changeStatus(int $id, string $status, array $fillable = []): void
    {
        $task = $this->task->find($id);
        $task->fill(array_merge($fillable, ['status' => $status]));
        $task->save();
    }
}
