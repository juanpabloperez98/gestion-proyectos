<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->authorizeResource(Task::class, 'task');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $project_id = $request->query('project_id');
        if(!$project_id){
            return response()->json(['message' => 'Project id neccesary'], 400);
        }
        $admin = false;
        foreach($user->roles as $rol){
            $admin = $rol->name == 'admin' ? true : false;
        }
        if($admin){
            $tasks = Task::where('project_id',$project_id)->get();
        }else{
            $tasks = Task::where('project_id',$project_id)->whereHas('project', function($q) use ($user){
                $q->where('user_id',$user->id);
            })->get();
        }
        return new TaskCollection($tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        //
        $input = $request->validated();
        $task = Task::create($input);
        return new TaskResource($task);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */

    private function fillUpdate($arr, $model){
        $model->update($arr);
    }

    public function update(TaskRequest $request, Task $task)
    {
        $this->fillUpdate($request->validated(), $task);
        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }

    function filter(Request $request){
        $project_id = $request->query('project_id');
        if(!$project_id){
            return response()->json(['message' => 'Project id neccesary'], 400);
        }
        $status = $request->query('status');
        $status_available = ["Pending","In Progress","Completed"];
        if(!in_array($status,$status_available)){
            return response()->json(['message' => 'Status not available'], 400);
        }
        $user = auth()->user();
        $admin = false;
        foreach($user->roles as $rol){
            $admin = $rol->name == 'admin' ? true : false;
        }
        if($admin){
            $query = Task::where('project_id',$project_id);
        }else{
            $query = Task::where('project_id',$project_id)->whereHas('project', function($q) use ($user){
                $q->where('user_id',$user->id);
            });
        }
        if($status){
            $query->where('status', $status);
        }
        $tasks = $query->get();
        return new TaskCollection($tasks);
    }
}
