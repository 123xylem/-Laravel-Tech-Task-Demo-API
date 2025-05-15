<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\URL;


class TaskController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return TaskResource::collection(Task::all());
    }

    public function store(TaskRequest $request): JsonResponse
    {
        $task = Task::create($request->validated());

        return response()->json([
            'task' => new TaskResource($task),
            'edit_url' => URL::signedRoute("tasks.update", ["task" => $task->id]),
            'delete_url' => URL::signedRoute("tasks.destroy", ["task" => $task->id])
        ], 201);
    }

    public function show(Task $task): TaskResource
    {
        return new TaskResource($task);
    }

    public function update(TaskRequest $request, Task $task): JsonResponse
    {

        try {
            $task->update($request->validated());
            return response()->json(new TaskResource($task));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function destroy(Task $task): JsonResponse
    {
        $task->delete();
        return response()->json(null, 204);
    }
}
