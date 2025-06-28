<?php

namespace App\Http\Controllers;

use App\Jobs\DeleteCompletedTask;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    protected TaskRepository $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    // listando todas as tarefas
    public function index(): JsonResponse
    {
        $tasks = $this->repository->all();
        return response()->json(['data' => $tasks], 200);
    }

    // Criar nova tarefa
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'finalizado' => 'boolean',
            'data_limite' => 'nullable|date',
        ]);

        $task = Task::create($validated);

        $this->repository->clearAll();

        return response()->json(['data' => $task], 201);
    }

    // Mostrar uma tarefa
    public function show(Task $task): JsonResponse
    {
        $task = $this->repository->find($task->id);
        return response()->json(['data' => $task], 200);
    }

    // Atualizar uma tarefa
    public function update(Request $request, Task $task): JsonResponse
    {
        $validated = $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'descricao' => 'nullable|string',
            'finalizado' => 'boolean',
            'data_limite' => 'nullable|date',
        ]);

        $task->update($validated);
        
        $this->repository->clearById($task->id);
        $this->repository->clearAll();

        return response()->json(['data' => $task], 200);
    }

    // Deletar (soft delete)
    public function destroy(Task $task): JsonResponse
    {
        $task->delete();

        $this->repository->clearById($task->id);
        $this->repository->clearAll();

        return response()->json(['message' => 'Tarefa deletada com sucesso.'], 200);
    }

    // Alternar status (toggle) finalizado
    public function toggle(Task $task): JsonResponse
    {
        $task->finalizado = !$task->finalizado;
        $task->save();

        $this->repository->clearById($task->id);
        $this->repository->clearAll();

        if ($task->finalizado) {
            DeleteCompletedTask::dispatch($task)->delay(now()->addMinutes(10));
        }

        return response()->json(['data' => $task], 200);
    }
}
