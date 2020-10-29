<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use JWTAuth;
use Validator;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|min:3|max:25|unique:users',
            'firstname' => 'required|min:3|max:25',
            'lastname' => 'required|min:3|max:25',
            'birthdate' => 'required|date:yyyy-mm-dd',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
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

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->messages();

            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' =>
                $errors,
            ], 401);
        }

        // grab credentials from the request
        $credentials = $request->only('username', 'password');
        $token = null;

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => ['The password or username you entered is wrong!'],
                ], 401);
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
                'errors' => ['This account is still not usable! Please contact admin for more info.'],
            ], 403);
        } elseif ($user->role == 'admin' && $user->status == 'inactive') {
            return response()->json([
                'message' => 'The user was invalid.',
                'errors' => ['This account can no longer be used!'],
            ], 403);
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
        ]);

        $credentials = $request->only('username');
        $token = null;

        $token = JWTAuth::invalidate($credentials);

        return response()->json(
            [
                'message' => 'Success Logout!',
            ]
        );
    }
}
