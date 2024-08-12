<?php

namespace App\Http\Services\Telegram;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\TaskHistory;

class TaskHistoryService
{
    private TaskHistory $taskHistory;

    public function __construct(TaskHistory $taskHistory)
    {
        $this->taskHistory = $taskHistory;
    }

    /**
     * @param array $fillable
     * @return TaskHistory
     */
    public function add(array $fillable = []) : TaskHistory
    {
        return $$this->instance($fillable)->save();
    }

    /**
     * @param array $fillable
     * @return TaskHistory
     */
    private function instance(array $fillable = []) : TaskHistory
    {
        return $this->taskHistory->fill($fillable);
    }
}
