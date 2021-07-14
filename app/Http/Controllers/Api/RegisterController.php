<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            $response = [
                'success' => false,
                'message' => 'Validation Error.',
                'data' => $validator->errors(),
            ]; 
            return response()->json($response, 402);  
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('My-Trello-App')->accessToken;      //creating access token
        $success['name'] =  $user->name;
        $response = [
            'success' => true,
            'message' => 'User register successfully.',
            'data' => $success,
        ];
        return response()->json($response, 200);
    }
}
