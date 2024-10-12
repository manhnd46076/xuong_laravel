<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $data = $project->tasks;
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        // dd($request);
        $request->validate([
            'task_name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required'
        ]);

        try {
            $task = $project->tasks()->create($request->all());
            // $task = Task::query()->create($request->all());
            return response()->json($task, 201);
        } catch (\Throwable $th) {
            Log::error(
                __CLASS__ . '@' . __FUNCTION__,
                ['error' => $th->getMessage()]
            );

            return response()->json([
                'msg' => 'Lỗi hệ thống'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(  Project $project,Task $task)
    {
        // $task = Task::find($id);

        if ($task->project_id !== $project->id) {
            return response()->json([
                'msg' => 'Không tìm thấy bản ghi thuộc Project  này  ' 
            ],404);
        }

        return response()->json($task);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  Project $project, Task $task)
    {
        $request->validate([
            'task_name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required',
        ]);

        if ($task->project_id !== $project->id) {
            return response()->json([
                'msg' => 'Không tìm thấy bản ghi thuộc Project  ID = ' . $project->id
            ]);
        }

        try {
            $task->update($request->all());
            return response()->json($task, 201);
        } catch (\Throwable $th) {
            Log::error(
                __CLASS__ . '@' . __FUNCTION__,
                ['error' => $th->getMessage()]
            );

            return response()->json([
                'msg' => 'Lỗi hệ thống'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Project $project, Task $task)
    {
        if ($task->project_id !== $project->id) {
            return response()->json([
                'msg' => 'Không tìm thấy bản ghi thuộc Project  ID = ' . $project->id
            ]);
        }
        $task->delete();
        return response()->json([], 204);
    }
}
