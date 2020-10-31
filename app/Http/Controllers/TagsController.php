<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class TagsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->role == 'user') {
            return response()->json([
                'message' => 'The user role was invalid.',
                'errors' => ['Access is not allowed!'],
            ], 403);
        }

        $tag = Tags::all();

        return response()->json($tag, 200);
    }

    public function tag_only(Request $request)
    {
        if ($request->user()->role == 'user') {
            return response()->json([
                'message' => 'The user role was invalid.',
                'errors' => ['Access is not allowed!'],
            ], 403);
        }

        $tag = Tags::select('tagname')->get();

        if (is_null($tag)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => ['Data not found!'],
            ], 404);
        }

        return response()->json($tag, 200);
    }

    public function create(request $request)
    {
        $validate = Validator::make($request->all(), [

            'tagname' => 'required|min:3|max:20|unique:tags',
            'description' => 'required|min:5',
        ]);

        if ($validate->fails()) {
            $errors = $validate->errors()->all();

            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $errors,
            ], 401);
        }

        $tag = $request->user()->tags()->create([
            'tagname' => $request->json('tagname'),
            'description' => $request->json('description'),
            'slug' => Str::slug($request->json('tagname')),
            'created_by' => $request->user()->firstname . ' ' . $request->user()->lastname,
        ]);

        return response()->json(
            [
                'message' => 'Success Create Tag',
            ], 200
        );

    }

    public function getById(Request $request, $id)
    {
        if ($request->user()->role == 'user') {
            return response()->json([
                'message' => 'The user role was invalid.',
                'errors' => ['Access is not allowed!'],
            ], 403);
        }

        $tag = Tags::find($id);

        if (is_null($tag)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => ['Data not found!'],
            ], 404);
        }

        return response()->json($tag, 200);
    }

    public function update(Request $request, $id)
    {
        if ($request->user()->role == 'user') {
            return response()->json([
                'message' => 'The user role was invalid.',
                'errors' => ['Access is not allowed!'],
            ], 403);
        }

        $validate = Validator::make($request->all(), [

            'tagname' => 'required|min:3|max:20|unique:tags',
            'description' => 'required|min:5',
        ]);

        if ($validate->fails()) {
            $errors = $validate->errors()->all();

            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $errors,
            ], 401);
        }

        $tag = Tags::find($id);

        if (is_null($tag)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => ['Data not found!'],
            ], 404);
        }

        $tag->tagname = $request->tagname;
        $tag->description = $request->description;
        $tag->slug = Str::slug($request->tagname);
        $tag->update_by = $request->user()->firstname . ' ' . $request->user()->lastname;
        $tag->updated_at = \Carbon\Carbon::now();
        $tag->save();

        return response()->json(
            [
                'message' => 'Success Update Tag',
            ], 200
        );
    }

    public function delete(Request $request, $id)
    {
        if ($request->user()->role == 'user') {
            return response()->json([
                'message' => 'The user role was invalid.',
                'errors' => ['Access is not allowed!'],
            ], 403);
        }

        $tag = Tags::find($id);

        if (is_null($tag)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => ['Data not found!'],
            ], 404);
        }

        $tag->isDeleted = true;
        $tag->deleted_by = $request->user()->firstname . ' ' . $request->user()->lastname;
        $tag->deleted_at = \Carbon\Carbon::now();
        $tag->save();

        $tag->delete();

        return response()->json(
            [
                'message' => 'Success Delete Tag',
            ], 200
        );
    }
}
