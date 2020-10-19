<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tags;
use Illuminate\Support\Str;

class TagsController extends Controller
{
    public function index()
    {
        return Tags::all();
    }

    public function tag_only()
    {
        $tag = Tags::select('tagname')->get();

        if (is_null($tag)) {
            return response()->json(["message" => "Record not found"], 404);
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
                'Status' => 'Success Create Tag',
            ]
        );

    }

    public function getById($id)
    {
        $tag = Tags::find($id);

        if (is_null($tag)) {
            return response()->json(["message" => "Record not found"], 404);
        }

        return response()->json($tag, 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'tagname' => 'required|min:3|max:20',
            'description' => 'required|min:5',
        ]);

        $tag = Tags::find($id);

        if (is_null($tag)) {
            return response()->json(["message" => "Record not found"], 404);
        }

        $tag->tagname = $request->tagname;
        $tag->description = $request->description;
        $tag->slug = Str::slug($request->tagname);
        $tag->update_by = $request->update_by;
        $tag->updated_at = $request->updated_at;
        $tag->save();

        return response()->json(
            [
                'Status' => 'Success Update Tag',
            ]
        );
    }

    public function delete(Request $request, $id)
    {
        $tag = Tags::find($id);

        if (is_null($tag)) {
            return response()->json(["message" => "Record not found"], 404);
        }

        $tag->isDeleted = $request->isDeleted;
        $tag->deleted_by = $request->deleted_by;
        $tag->save();

        $tag->delete();

        return response()->json(
            [
                'Status' => 'Success Delete Tag',
            ]
        );
    }
}
