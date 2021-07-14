<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            $response = [
                'success' => false,
                'message' => 'Validation Error.',
                'data' => $validator->errors(),
            ]; 
            return response()->json($response, 402);  
        }
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('My-Trello-App')-> accessToken; 
            $success['name'] =  $user->name;
            $response = [
                'success' => true,
                'message' => 'User Login successfully.',
                'data' => $success,
            ];
            return response()->json($response, 200);
        } 
        else{ 
            $response = [
                'success' => false,
                'message' => 'Unauthorised.',
                'data' => ['error'=>'Unauthorised'],
            ];
            return response()->json($response, 403);
        } 
    }
}
