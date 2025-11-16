<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Resources\TaskResource;
use Tymon\JWTAuth\Facades\JWTAuth;

class TaskApiController extends Controller
{
    // GET TASK USER / ADMIN
    public function index()
    {
        $user = JWTAuth::user();

        if ($user->role == 1) {
            // admin -> semua task
            $tasks = Task::all();
        } else {
            // user -> task yang dibuat atau diassign ke dia
            $tasks = Task::where('created_by', $user->id)
                        ->orWhere('assigned_to', $user->id)
                        ->get();
        }

        return TaskResource::collection($tasks);
    }

    // SHOW DETAIL TASK
    public function show(Task $task)
    {
        $user = JWTAuth::user();

        if ($user->role == 0 && 
            $task->created_by != $user->id && 
            $task->assigned_to != $user->id) 
        {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        return new TaskResource($task);
    }

    // ADMIN CREATE
    public function store(Request $request)
    {
        $user = JWTAuth::user();
        if ($user->role != 1) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $data = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $data['created_by'] = $user->id;
        $data['status'] = 0;

        $task = Task::create($data);

        return new TaskResource($task);
    }

    // UPDATE TASK
    public function update(Request $request, Task $task)
    {
        $user = JWTAuth::user();

        if ($user->role == 1) {
            // ADMIN → boleh update semua
            $data = $request->validate([
                'title' => 'sometimes|string',
                'description' => 'sometimes|string',
                'status' => 'sometimes|integer',
                'assigned_to' => 'sometimes|exists:users,id'
            ]);

            $task->update($data);
            return new TaskResource($task);
        }

        // USER BIASA
        if ($task->created_by != $user->id && $task->assigned_to != $user->id) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        // USER hanya boleh update STATUS
        $data = $request->validate([
            'status' => 'required|integer'
        ]);

        $task->update(['status' => $data['status']]);
        return new TaskResource($task);
    }

    // DELETE
    public function destroy(Task $task)
    {
        $user = JWTAuth::user();

        if ($user->role == 1 || $task->created_by == $user->id) {
            $task->delete();
            return response()->json(['message' => 'Task deleted']);
        }

        return response()->json(['error' => 'Forbidden'], 403);
    }
}
