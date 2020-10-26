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
            'birthdate' => 'required|date:yyyy-mm-dd',
            'email' => 'required|unique:users',
            'password' => 'required',
            'phonenumber' => 'required|numeric|digits_between:10,12|unique:users',
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
                'message' => 'Register Success!',
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
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => [
                        'password' => ['The password or username you entered is wrong!'],
                    ]], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json([
                'message' => 'Could not create token!',
            ], 500);
            //return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user = User::find($request->user()->id);

        if ($user->role == 'admin' && $user->isVerified == false) {
            return response()->json([
                'message' => 'The user was invalid.',
                'errors' => [
                    'user' => ['This account is still not usable! Please contact admin for more info.'],
                ]], 403);
        } elseif ($user->role == 'admin' && $user->status == 'inactive') {
            return response()->json([
                'message' => 'The user was invalid.',
                'errors' => [
                    'user' => ['This account can no longer be used!'],
                ]], 403);
        }

        // all good so return the token
        return response()->json(
            [
                'user_id' => $request->user()->id,
                'token' => $token,
                'username' => $user->username,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'email' => $user->email,
                'phonenumber' => $user->phonenumber,
                'imageprofile' => $user->imageprofile,
                'role' => $user->role,

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
                'message' => 'Success Logout!',
            ]
        );
    }
}
