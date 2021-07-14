<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    /* List of All Registered Users */
    public function index()
    {
        $users = User::with('taskBoards', 'taskBoards.tasks')
            ->withCount(['taskBoards','tasks'])
            ->get();
        //calling a collection resource
        return UserResource::collection($users);
    }
}
