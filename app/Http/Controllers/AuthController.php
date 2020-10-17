<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use JWTAuth;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:users',
            'firstname' => 'required',
            'lastname' => 'required',
            'birthdate' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'phonenumber' => 'required|numeric|digits_between:10,12',
        ]);

        $auth = User::create([
            'username' => $request->json('username'),
            'firstname' => $request->json('firstname'),
            'lastname' => $request->json('lastname'),
            'birthdate' => $request->json('birthdate'),
            'email' => $request->json('email'),
            'password' => bcrypt($request->json('password')),
            'phonenumber' => strval($request->json('phonenumber')),
            'imageprofile' => $request->json('imageprofile'),
            'role' => $request->json('role'),
            'status' => $request->json('status'),
            'update_by' => $request->json('update_by'),
        ]);

        return response()->json(
            [
                'Status' => 'Register Success',
            ]
        );
    }

    public function signin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        // grab credentials from the request
        $credentials = $request->only('username', 'password');
        $token = null;

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(
            [
                'user_id' => $request->user()->id,
                'token' => $token,
            ]
        );
    }

    public function signout(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');
        $token = null;

        $token = JWTAuth::invalidate($credentials);

        return response()->json(
            [
                'Status' => 'Success',
            ]
        );
    }
}
