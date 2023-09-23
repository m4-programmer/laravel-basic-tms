<?php

namespace App\Http\Controllers;

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
    public function index()
    {
        $tasks = Task::latest()->get();
        $projects = Project::get();
        return view('welcome',compact('tasks','projects'));
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
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string',
            'priority'=>'required|string|in:High,Medium,Low',
            'timestamp' => 'nullable|date_format:Y-m-d\TH:i',
            'project_id'=>'required|exists:projects,id'
        ]);
        try {
            $task = Task::create($data+['ip'=>$request->ip()]);
            if ($task) {
                // Task created successfully, return a success response
                return response(['message' => 'Task created successfully','task'=>$task], 200);
            } else {
                // An error occurred, return a validation error response
                return response(['errors' => 'An error occurred'], 422);
            }
        }catch (\Exception $e){
            Log::error($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $task = Task::findorfail($id);
        return view('tasks',compact('task'));
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
    public function destroy(int $id)
    {
        $task = Task::findorfail($id);
        $task->delete();
        return response(['message'=>'task deleted successfully'], 200);
    }
}
