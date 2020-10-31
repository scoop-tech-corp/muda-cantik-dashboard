<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = User::find($request->user()->id);

        if ($user->role == 'admin' || $user->role == 'user') {

            $getuser = User::find($request->user()->id);
            //$getuser = DB::table('users')->where('id', $request->user()->id);

            if (is_null($getuser)) {
                return response()->json([
                    'message' => 'The data was invalid.',
                    'errors' => ['Data not found!'],
                ], 404);

            } else {
                return response()->json($getuser, 200);

            }

        } else {

            $getuser = User::all();
            return response()->json($getuser, 200);

        }
    }

    public function getByUser(Request $request, $id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => ['Data not found!'],
            ], 404);
        }

        if ($request->user()->role = 'admin' || $request->user()->role = 'user') {

            if ($user->id != $request->user()->id) {

                return response()->json([
                    'message' => 'The user role was invalid.',
                    'errors' => ['Access is not allowed!'],
                ], 403);
            }
        }

        return response()->json($user, 200);
    }

    public function Update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [

            'firstname' => 'required|min:3|max:25',
            'lastname' => 'required|min:3|max:25',
            'birthdate' => 'required|date:yyyy-mm-dd',
        ]);

        if ($validate->fails()) {
            $errors = $validate->errors()->all();

            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $errors,
            ], 401);
        }

        $user = User::find($id);

        if (is_null($user)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => ['Data not found!'],
            ], 404);
        }

        if ($request->user()->id != $id) {
            return response()->json([
                'message' => 'The user role was invalid.',
                'errors' => ['Access is not allowed!'],
            ], 403);
        }

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->birthdate = $request->birthdate;
        $user->update_by = $request->user()->firstname . ' ' . $request->user()->lastname;
        $user->updated_at = \Carbon\Carbon::now();
        $user->save();

        return response()->json(
            [
                'message' => 'Success Update User!',
            ], 200
        );
    }

    public function VerifiedAdmin(Request $request, $id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => ['Data not found!'],
            ], 404);
        }

        if ($request->user()->role == 'admin' || $request->user()->role == 'user') {
            return response()->json([
                'message' => 'The user role was invalid.',
                'errors' => ['Access is not allowed!'],
            ], 403);

        } elseif ($user->role == 'user') {
            return response()->json([
                'message' => 'The user role was invalid.',
                'errors' => ['Cannot update user role status!'],
            ], 403);

        }

        $user->isVerified = true;
        $user->status = 'active';
        $user->email_verified_at = \Carbon\Carbon::now();
        $user->verifiedby = $request->user()->firstname . ' ' . $request->user()->lastname;
        $user->save();

        return response()->json(
            [
                'message' => 'Success Update Admin Status!',
            ]
        );
    }

    public function Inactive(Request $request, $id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => ['Data not found!'],
            ], 404);
        }

        if ($request->user()->role == 'admin' || $request->user()->role == 'user') {

            return response()->json([
                'message' => 'The user role was invalid.',
                'errors' => ['Access is not allowed!'],
            ], 403);
        }

        $user->status = 'inactive';
        $user->inactive_at = \Carbon\Carbon::now();
        $user->inactive_by = $request->user()->firstname . ' ' . $request->user()->lastname;

        $user->save();

        return response()->json(
            [
                'message' => 'Success Update Status User!',
            ]
        );
    }

}
