<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Wallet;
class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'name'=>'required|string',
            'email'=>'required|string|unique:users,email',
            'password'=>'required'
        ]);


    $user = User::create([
        'name'=> $fields['name'],
        'email' => $fields['email'],
        'password'=> bcrypt($fields['password'])
    ]);

    $user->wallet()->create(['bills'=>500]);
    $user->fields()->create();

    $token = $user->createtoken('relxgapp')->plainTextToken;

    $response = [
        /*'user' => $user->with('wallet','fields')->get(),*/
        'user_id' => $user->id,
        'token' => $token
    ];

    return response($response,201);

    }

    public function login(Request $request){
        $fields = $request->validate([
            'email'=>'required|string',
            'password'=>'required'
        ]);

        //check email
        $user = User::where('email',$fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response([
                'message' => 'Bad credentials. Try again.'
            ], 401);
        }

    $token = $user->createtoken('relxgapp')->plainTextToken;

    $response = [
        /*'user' => $user->with('wallet','fields')->first(),*/
        'user_id' => $user->id,
        'token' => $token
    ];

    return response($response,201);

    }

    public function logout(){
        auth()->user()->tokens()->delete();

        return [
            'message'=>'Logged out.'
        ];
    }

}
