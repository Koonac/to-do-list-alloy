<?php

namespace App\Jobs;

use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DeleteCompletedTask implements ShouldQueue
{
    use Queueable;

    protected Task $task;
    protected TaskRepository $repository;

    /**
     * Create a new job instance.
     */
    public function __construct(Task $task, TaskRepository $repository)
    {
        $this->task = $task;
        $this->repository = $repository;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $task = Task::withTrashed()->find($this->task->id);

        if ($task && $task->finalizado && !$task->deleted_at) {
            $this->repository->clearById($task->id);
            $this->repository->clearAll();
            $task->forceDelete();
        }
    }
}
