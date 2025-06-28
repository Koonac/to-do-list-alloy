<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;

class TaskRepository
{
    protected string $tag = 'tasks';

    public function all(): Collection
    {
        return Cache::remember('tasks_all', now()->addMinutes(10), function () {
            return Task::all();
        });
    }

    public function find(int $id): ?Task
    {
        return Cache::remember("task_{$id}", now()->addMinutes(10), function () use ($id) {
            return Task::find($id);
        });
    }

    public function clearAll(): void
    {
        Cache::forget('tasks_all');
    }

    public function clearById(int $id): void
    {
        Cache::forget("task_{$id}");
    }
}
