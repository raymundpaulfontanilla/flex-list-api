<?php

namespace App\Http\Controllers;

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
    public function store()
    {
        $task = User::find(1);

        if (!$task) {
            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'errorCode' => 'USER_NOT_FOUND',
                'message' => 'Please register first',
                'task' => null
            ], 404);
        }

        $task = Task::create([
            'user_id' => 2,
            'title' => 'Task 2',
            'description' => 'Description 2',
            'is_completed' => false,
            'display_order' => 0,
        ]);

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Task Created',
            'task' => ([
                'id' => $task->id,
                'user_id' => $task->user_id,
                'title' => $task->title,
                'description' => $task->description,
                'is_completed' => $task->is_completed,
                'display_order' => $task->display_order,
            ]),
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
            'project' => $task
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
