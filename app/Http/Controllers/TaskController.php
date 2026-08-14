<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if ($request->has('id')) {
            $task = User::find($request->id);

            if (!$task) {
                return response()->json([
                    'success' => false,
                    'statusCode' => 404,
                    'errorCode' => 'USER_NOT_FOUND',
                    'message' => 'Please register first',
                    'task' => null
                ], 404);
            }

            return response()->json([
                'success' => true,
                'tasks' => $task
            ]);
        }

        $tasks = Task::with('user')->get();

        return response()->json([
            'success' => true,
            'task' => $tasks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $validatedData = $request->validated();

        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'errorCode' => 'USER_NOT_FOUND',
                'message' => 'Please register first',
                'task' => null
            ], 404);
        }

        $task = Task::create(array_merge($validatedData, [
            'user_id' => $user->id
        ]));

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Task Created',
            'task' => $task
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'errorCode' => 'TASK_NOT_FOUND',
                'message' => 'Task not found',
                'task' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'task' => $task
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, string $id)
    {
        $validatedData = $request->validated();

        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'errorCode' => 'TASK_NOT_FOUND',
                'message' => 'Task not found',
                'project' => null
            ], 404);
        }

        $task->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Task updated',
            'task' => $task
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'errorCode' => 'TASK_NOT_FOUND',
                'message' => 'Task not found',
                'project' => null
            ], 404);
        }

        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Task deleted',
        ]);
    }
}
