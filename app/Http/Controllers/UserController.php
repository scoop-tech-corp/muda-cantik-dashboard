<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index($id)
    {
        $user = User::find($id);

        if ($user->role == 'admin') {
            return response()->json([
                'message' => 'The user role was invalid.',
                'errors' => [
                    'user' => ['Access is not allowed!'],
                ]], 403);
        }

        return User::all();
    }

    public function getByUser($id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => [
                    'data' => ['Data not found!'],
                ]], 404);
        }

        return $user;
    }

    public function Update(Request $request, $id)
    {
        $this->validate($request, [
            'username' => 'required|unique:users',
            'firstname' => 'required',
            'lastname' => 'required',
            'birthdate' => 'required|date_format:yyyy-mm-dd',
            'email' => 'required|unique:users',
            'password' => 'required',
            'phonenumber' => 'required|numeric|digits_between:10,12|unique:users',
        ]);

        $user = User::find($id);

        if (is_null($user)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => [
                    'data' => ['Data not found!'],
                ]], 404);
        }

        if ($request->user()->id != $user->id) {
            return response()->json([
                'message' => 'The user role was invalid.',
                'errors' => [
                    'user' => ['Access is not allowed!'],
                ]], 403);
        }
    }

    public function VerifiedAdmin(Request $request, $id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => [
                    'data' => ['Data not found!'],
                ]], 404);
        }

        $chk_user = User::find($request->userid);

        if ($chk_user->role == 'admin' || $chk_user->role == 'user') {
            return response()->json([
                'message' => 'The user role was invalid.',
                'errors' => [
                    'user' => ['Access is not allowed!'],
                ]], 403);
        }

        $user->isVerified = $request->isVerified;
        $user->email_verified_at = $request->email_verified_at;
        $user->verifiedby = $request->verifiedby;
        $user->save();

        return response()->json(
            [
                'message' => 'Success Update Admin Status!',
            ]
        );
    }

    public function Activation(Request $request, $id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => [
                    'data' => ['Data not found!'],
                ]], 404);
        }

        $chk_user = User::find($request->userid);

        if ($chk_user->role == 'admin' || $chk_user->role == 'user') {
            return response()->json([
                'message' => 'The user role was invalid.',
                'errors' => [
                    'user' => ['Access is not allowed!'],
                ]], 403);
        }

        $user->status = $request->status;
        $user->save();

        return response()->json(
            [
                'message' => 'Success Update Status User!',
            ]
        );
    }
}
