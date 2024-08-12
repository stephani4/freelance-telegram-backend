<?php

namespace App\Http\Controllers\Api\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Services\Telegram\TaskService;

class TasksListController extends Controller
{
    const PER_PAGE = 10;

    private TaskService $taskService;

    public function __construct()
    {
        $this->taskService = new TaskService();
    }

    /**
     * @return mixed
     */
    public function index(): mixed
    {
        $countByDate = $this->countTasksFilter($this->getFilterCount());

        return response()->json([
            'countByDate' => $countByDate,
        ]);
    }

    /**
     * @return array
     */
    private function getFilterCount(): array
    {
        return [
            'date_from' => date('Y-m-d 00:00:00'),
            'date_to'   => date('Y-m-d 23:59:59')
        ];
    }

    /**
     * @param array $filters
     * @return mixed
     */
    private function countTasksFilter(array $filters = [])
    {
        return $this->taskService->countTasksByFilter($filters);
    }
}
