<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function __construct() {
        $this->user =  ( Auth::check() ) ? Auth::user()->id : 2 ;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::latest()->get();
        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskStoreRequest $request)
    {
        $user = $this->user;
        $task = Task::create(
            [
                'name'=>$request->input('name'),
                'user_id'=>  $user ,

            ]
            );
        return response(['message'=>"Todo task created successfully"], Response::HTTP_OK)    ;
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($taskId)
    {
        $task = Task::findOrFail($taskId);
        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskUpdateRequest $request, $taskId)
    {
        $task = Task::findOrFail($taskId);
        $data = $request->validated() ;
        if ( $request->input('completed') == true ) {
            $data['completed'] =true;
            $data['completed_at'] = Carbon::now() ;
        }
        $data["user_id"] = $this->user;
        $task->update($data) ;
        return response(['message'=>"Todo task updated successfully"], Response::HTTP_OK)    ;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($taskId)
    {
        $task = Task::findOrFail($taskId) ->delete() ;

        return response(['message'=>"Todo task deleted successfully"], Response::HTTP_OK)    ;

    }
}
