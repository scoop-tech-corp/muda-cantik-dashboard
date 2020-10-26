<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tags;
use Illuminate\Support\Str;

class TagsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->role == 'user') {
            return response()->json([
                'message' => 'The user role was invalid.',
                'errors' => [
                    'user' => ['Access is not allowed!'],
                ]], 403);
        }

        $tag = Tags::all();

        return response()->json($tag, 200);
    }

    public function tag_only(Request $request)
    {
        if ($request->user()->role == 'user') {
            return response()->json([
                'message' => 'The user role was invalid.',
                'errors' => [
                    'user' => ['Access is not allowed!'],
                ]], 403);
        }

        $tag = Tags::select('tagname')->get();

        if (is_null($tag)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => [
                    'data' => ['Data not found!']
                ]], 404);
        }

        return response()->json($tag, 200);
    }

    public function create(request $request)
    {
        $this->validate($request, [
            'tagname' => 'required|min:3|max:20|unique:tags',
            'description' => 'required|min:5',
        ]);

        $tag = $request->user()->tags()->create([
            'tagname' => $request->json('tagname'),
            'description' => $request->json('description'),
            'slug' => Str::slug($request->json('tagname')),
            'created_by' => $request->json('created_by'),
        ]);

        return response()->json(
            [
                'message' => 'Success Create Tag',
            ],200
        );

    }

    public function getById(Request $request, $id)
    {
        if ($request->user()->role == 'user') {
            return response()->json([
                'message' => 'The user role was invalid.',
                'errors' => [
                    'user' => ['Access is not allowed!'],
                ]], 403);
        }

        $tag = Tags::find($id);

        if (is_null($tag)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => [
                    'data' => ['Data not found!']
                ]], 404);
        }

        return response()->json($tag, 200);
    }

    public function update(Request $request, $id)
    {
        if ($request->user()->role == 'user') {
            return response()->json([
                'message' => 'The user role was invalid.',
                'errors' => [
                    'user' => ['Access is not allowed!'],
                ]], 403);
        }

        $this->validate($request, [
            'tagname' => 'required|min:3|max:20',
            'description' => 'required|min:5',
        ]);

        $tag = Tags::find($id);

        if (is_null($tag)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => [
                    'data' => ['Data not found!']
                ]], 404);
        }

        $tag->tagname = $request->tagname;
        $tag->description = $request->description;
        $tag->slug = Str::slug($request->tagname);
        $tag->update_by = $request->update_by;
        $tag->updated_at = $request->updated_at;
        $tag->save();

        return response()->json(
            [
                'message' => 'Success Update Tag',
            ],200
        );
    }

    public function delete(Request $request, $id)
    {
        if ($request->user()->role == 'user') {
            return response()->json([
                'message' => 'The user role was invalid.',
                'errors' => [
                    'user' => ['Access is not allowed!'],
                ]], 403);
        }

        $tag = Tags::find($id);

        if (is_null($tag)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => [
                    'data' => ['Data not found!']
                ]], 404);
        }

        $tag->isDeleted = $request->isDeleted;
        $tag->deleted_by = $request->deleted_by;
        $tag->save();

        $tag->delete();

        return response()->json(
            [
                'message' => 'Success Delete Tag',
            ],200
        );
    }
}
