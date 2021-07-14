<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Task;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    /* List of All Task Boards */
    public function index()
    {
        $tasks = Task::all();
        //calling a collection resource
        return TaskResource::collection($tasks);
    }

    /* Creating new Task Board */
    public function store(Request $request)
    {
        $input = $request->all();
        //using validator to validate a form field
        $validator = Validator::make($input, [
            'task_board_id' => 'required',
            'name' => 'required',
            'description' => 'required',
        ]);

        //if validation fails returning error response
        if($validator->fails()){
            return $validator->errors();       
        }

        $task = Task::create($input);   //calling create() to insert record
        $response = [
            'success' => true,
            'message' => 'New Task created successfully.',
            'data' => new TaskResource($task),
        ];
        return response()->json($response, 200);   //returning response in json format
    } 

    /* Updating Task */
    public function update(Request $request, Task $task)
    {
        $input = $request->all();
        //using validator to validate a form field
        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required',
        ]);
        //if validation fails returning error response
        if($validator->fails()){
            return $validator->errors();       
        }
   
        $task->name = $input['name'];                   //updating task name
        $task->description = $input['description'];     //updating task description
        $task->save();
        $response = [
            'success' => true,
            'message' => 'Task Updated successfully.',
            'data' => new TaskResource($task),
        ];
        return response()->json($response, 200);
    }

    /* Deleting Task */
    public function destroy(Task $task)
    {
        $task->delete();                           //deleting the task using delete method
        $response = [
            'success' => true,
            'message' => 'Task Deleted successfully.',
            'data' => [],
        ];
        return response()->json($response, 200);
    }
}
