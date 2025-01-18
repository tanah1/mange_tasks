<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function register(Request $request)
    {

        $validateData = Validator::make($request->all(), [
            'name' => 'required|min:3|max:20',
            'email' => 'required|email|unique:users,email,except,id',
            'password' => 'required|min:8|max:20'
        ]);

        if ($validateData->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'errors' => $validateData->errors()
                ],
                422
            );
        }

        $newUser = User::create($validateData->validated());

        return response()->json(
            [
                'success' => true,
                'message' => 'User created successfully',
                'data' => $newUser
            ],
            201
        );
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            $token = $user->createToken('manage tasks')->plainTextToken;

            return response()->json(
                [
                    'success' => true,
                    'message' => "login successfull",
                    'data' => [
                        "user" => $user,
                        'token' => $token
                    ]
                ]
            );
        }

        return response()->json(
            [
                'success' => false,
                'message' => 'Unauthorized'
            ],
            401
        );
    }

    public function getCurrentuser(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'success' => true,
            'message' => "user retrevied successfully",
            'data' => $user
        ], 200);
    }

    public function getUserById($id)
    {
        try{


        $user = User::findOrFail($id);
        return response()->json([
            'success' => true,
            'message' => "User retrieved successfully",
            'data' => $user
        ], 200);

        }catch(ModelNotFoundException $e){
            return response()->json([
                'success' => false,
                'message' => "User not found ".$e->getMessage()
            ], 404);

        }
    }


    public function updateUser(Request $request)
    {
        $user = $request->user();
        $findUser = User::find($user->id);
        if ($findUser) {
            $validateData = Validator::make($request->all(), [
                'name' => 'required|min:3|max:20',
                'email' => 'required|email|unique:users,email,except,id',
                'password' => 'required|min:8|max:20'
            ]);

            $findUser->update($validateData->validated());
            return response()->json(
                [
                    'success' => true,
                    'message' => "user updated successfully",
                    'data' => $findUser
                ],
                200
            );
        } else {
            return response()->json([
                'success' => false,
                'message' => "user not found"
            ], 404);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(
            [
                'success' => true,
                'message' => "user logedOut successfully"
            ],

        );
    }
}
