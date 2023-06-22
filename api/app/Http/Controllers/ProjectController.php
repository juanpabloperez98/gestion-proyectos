<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $user = auth()->user();
        $admin = false;
        foreach($user->roles as $rol){
            $admin = $rol->name == 'admin' ? true : false;
        }
        if($admin){
            $projects = Project::all();
        }else{
            $projects = Project::where('user_id', $user->id)->get();
        }
        return new ProjectCollection($projects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ProjectRequest $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        //
        $input = $request->validated();
        $user = auth()->user();
        $input['user_id'] = $user->id;
        $newProject = Project::create($input);
        return new ProjectResource($newProject);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $user = auth()->user();
        $admin = false;
        foreach($user->roles as $rol){
            $admin = $rol->name == 'admin' ? true : false;
        }
        if($admin){
            return new ProjectResource($project);
        }else{
            if($project->user_id == $user->id){
                return new ProjectResource($project);
            }
            return response()->json(['message' => 'Rol user dont have permission to show'], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    private function fillUpdate($arr, $model){
        $model->update($arr);
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $user = auth()->user();
        $admin = false;
        foreach($user->roles as $rol){
            $admin = $rol->name == 'admin' ? true : false;
        }
        if($admin){
            $this->fillUpdate($request->validated(), $project);
        }else{
            if($project->user_id != $user->id){
                return response()->json(['message' => 'Rol user dont have permission to edit'], 400);
            }
            $this->fillUpdate($request->validated(), $project);
        }
        return new ProjectResource($project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $user = auth()->user();
        $admin = false;
        foreach($user->roles as $rol){
            $admin = $rol->name == 'admin' ? true : false;
        }
        if($admin){
            $project->delete();
        }else{
            if($project->user_id != $user->id){
                return response()->json(['message' => 'Rol user dont have permission to delete'], 400);
            }
            $project->delete();
        }
        return response()->json(['message' => 'Project deleted successfully']);
    }


    function filter(Request $request){
        $date_start = $request->query('date_start');
        $date_end = $request->query('date_end');
        $user = auth()->user();
        $admin = false;
        foreach($user->roles as $rol){
            $admin = $rol->name == 'admin' ? true : false;
        }
        if($admin){
            $query = Project::query();
        }else{
            $query = Project::where('user_id', $user->id);
        }
        if($date_start){
            $query->where('date_start', $date_start);
        }
        if($date_end){
            $query->where('date_end', $date_end);
        }
        $projects = $query->get();
        return new ProjectCollection($projects);
    }
}
