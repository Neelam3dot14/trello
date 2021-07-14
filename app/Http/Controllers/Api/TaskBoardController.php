<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\TaskBoard;
use App\Http\Resources\TaskBoardResource as BoardResource;

class TaskBoardController extends Controller
{
    /* List of All Task Boards */
    public function index()
    {
        $boards = TaskBoard::all();
        //calling a collection resource
        return BoardResource::collection($boards);
    }

    /* Creating new Task Board */
    public function store(Request $request)
    {
        $input = $request->all();
        //using validator to validate a form field
        $validator = Validator::make($input, [
            'board_name' => 'required',
        ]);

        //if validation fails returning error response
        if($validator->fails()){
            return $validator->errors();       
        }

        $input['user_id'] = \Auth::id();          //getting current authenticated user id
        $taskBoard = TaskBoard::create($input);   //calling create() to insert record
        $response = [
            'success' => true,
            'message' => 'New Task Board created successfully.',
            'data' => new BoardResource($taskBoard),
        ];
        return response()->json($response, 200);   //returning response in json format
    } 

    /* Updating Task Board */
    public function update(Request $request, TaskBoard $taskBoard)
    {
        $input = $request->all();
        //using validator to validate a form field
        $validator = Validator::make($input, [
            'board_name' => 'required',
        ]);
        //if validation fails returning error response
        if($validator->fails()){
            return $validator->errors();       
        }
   
        $taskBoard->board_name = $input['board_name'];     //saving new board name
        $taskBoard->save();
        $response = [
            'success' => true,
            'message' => 'Task Board updated successfully.',
            'data' => new BoardResource($taskBoard),
        ];
        return response()->json($response, 200);
    }

    /* Deleting Task Board */
    public function destroy(TaskBoard $taskBoard)
    {
        $taskBoard->delete();        //deleting the task_board using delete method
        $response = [
            'success' => true,
            'message' => 'Task Board Deleted successfully.',
            'data' => [],
        ];
        return response()->json($response, 200);
    }
}
