<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Project::latest('id')->paginate(5);
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'project_name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date'
        ]);

        try {
            $project = Project::query()->create($data);
            return response()->json($project, 201);
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
    public function show(string $id)
    {
        $prj = Project::find($id);
        if ($prj) {
            return response()->json($prj);
        }
        return response()->json([
            'msg' => 'Không tìm thấy bản ghi ID = ' . $id
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'project_name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date'
        ]);

        $project = Project::find($id);
        if (!$project) {
            return response()->json([
                'msg' => 'Không tìm thấy bản ghi ID = ' . $id
            ]);
        }

        try {
            $project->update($data);
            return response()->json($project, 201);
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
    public function destroy(string $id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json([
                'msg' => 'Không tìm thấy bản ghi ID = ' . $id
            ]);
        }
        $project->delete();
        return response()->json([
            'msg' => 'Xóa thành công bản ghi ID = ' . $id
        ], 204);
    }
}
