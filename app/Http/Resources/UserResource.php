<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $task_boards = [];
        //getting all task boards
        foreach($this->taskBoards as $board){
            $tasks = [];
            //getting all related tasks
            foreach($board->tasks as $t){
                $tasks[] = [
                    'name' => $t->name,
                    'description'=> $t->description,
                ];
            }
            $task_boards[] = [
                'name' => $board->board_name,
                'tasks' => $tasks,
            ];
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'task_boards' => $task_boards,                        //details of task boards
            'task_board_count' => $this->task_boards_count,       //total no of task boards
            'task_count' => $this->tasks_count,                   //total no tasks
            'created_at' => date('d-m-Y h:i:s', strtotime($this->created_at)),
        ];
    }
}
