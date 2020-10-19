<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function index()
    {
        return Categories::all();
    }

    public function categories_name()
    {
        $category = Categories::select('categories')->get();

        if (is_null($category)) {
            return response()->json(["message" => "Record not found!"], 404);
        }

        return response()->json($category, 200);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'categoriesname' => 'required|min:3|max:20|unique:categories',
            'description' => 'required|min:5',
        ]);

        $category = $request->user()->categories()->create([
            'categoriesname' => $request->json('categoriesname'),
            'description' => $request->json('description'),
            'slug' => Str::slug($request->json('categoriesname')),
            'message' => $request->json('message'),
            'created_by' => $request->json('created_by'),
        ]);

        return response()->json(
            [
                'Status' => 'Success Create Category!',
            ]
        );

    }

    public function getById($id)
    {
        $cat = Categories::find($id);

        if (is_null($cat)) {
            return response()->json(["message" => "Record not found!"], 404);
        }

        return response()->json($cat, 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'categoriesname' => 'required|min:3|max:20',
            'description' => 'required|min:5',
        ]);

        $cat = Categories::find($id);

        if (is_null($cat)) {
            return response()->json(["message" => "Record not found!"], 404);
        }

        if($request->user()->id != $cat->user_id)
        {
            return response()->json(["message" => "Cannot edit this data!"], 403);
        }

        $cat->categoriesname = $request->categoriesname;
        $cat->description = $request->description;
        $cat->slug = Str::slug($request->categoriesname);
        $cat->message = $request->message;
        $cat->update_by = $request->update_by;
        $cat->updated_at = $request->updated_at;
        $cat->save();

        return response()->json(
            [
                'Status' => 'Success Update Category!',
            ]
        );

    }

    public function delete(Request $request, $id)
    {
        $cat = Categories::find($id);

        if (is_null($cat)) {
            return response()->json(["message" => "Record not found"], 404);
        }

        $cat->isDeleted = $request->isDeleted;
        $cat->deleted_by = $request->deleted_by;
        $cat->save();

        $cat->delete();

        return response()->json(
            [
                'Status' => 'Success Delete Category!',
            ]
        );
    }
}
