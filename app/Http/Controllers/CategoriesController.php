<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->role == 'user') {
            return response()->json([
                'message' => 'The user role was invalid.',
                'errors' => ['Access is not allowed!'],
            ], 403);
        }

        $categories = Categories::all();
        return response()->json($categories, 200);
    }

    public function categories_name(Request $request)
    {
        if ($request->user()->role == 'user') {
            return response()->json([
                'message' => 'The user role was invalid.',
                'errors' => ['Access is not allowed!'],
            ], 403);
        }

        $category = Categories::select('categoriesname')->get();

        if (is_null($category)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => ['Data not found!'],
            ], 404);
        }

        return response()->json($category, 200);
    }

    public function create(Request $request)
    {
        $validate = Validator::make($request->all(), [

            'categoriesname' => 'required|min:3|max:20|unique:categories',
            'description' => 'required|min:5',
        ]);

        if ($validate->fails()) {
            $errors = $validate->errors()->all();

            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $errors,
            ], 401);
        }

        $category = $request->user()->categories()->create([
            'categoriesname' => $request->json('categoriesname'),
            'description' => $request->json('description'),
            'slug' => Str::slug($request->json('categoriesname')),
            'message' => $request->json('message'),
            'created_by' => $request->user()->firstname . ' ' . $request->user()->lastname,
        ]);

        return response()->json(
            [
                'message' => 'Success Create Category!',
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

        $cat = Categories::find($id);

        if (is_null($cat)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => ['Data not found!'],
            ], 404);
        }

        return response()->json($cat, 200);
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'categoriesname' => 'required|min:3|max:20',
            'description' => 'required|min:5',
        ]);

        if ($validate->fails()) {
            $errors = $validate->errors()->all();

            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $errors,
            ], 401);
        }

        $cat = Categories::find($id);

        if (is_null($cat)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => [
                    'data' => ['Data not found!'],
                ]], 404);
        }

        if ($request->user()->id != $cat->user_id) {
            return response()->json([
                'message' => 'The user was invalid.',
                'errors' => ['Access is not allowed!'],
            ], 403);
        }

        $cat->categoriesname = $request->categoriesname;
        $cat->description = $request->description;
        $cat->slug = Str::slug($request->categoriesname);
        $cat->message = $request->message;
        $cat->update_by = $request->user()->firstname . ' ' . $request->user()->lastname;
        $cat->updated_at = \Carbon\Carbon::now();
        $cat->save();

        return response()->json(
            [
                'message' => 'Success Update Category!',
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

        $cat = Categories::find($id);

        if (is_null($cat)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => ['Data not found!'],
            ], 404);
        }

        $cat->isDeleted = true;
        $cat->deleted_by = $request->user()->firstname . ' ' . $request->user()->lastname;
        $cat->deleted_at = \Carbon\Carbon::now();
        $cat->save();

        $cat->delete();

        return response()->json(
            [
                'message' => 'Success Delete Category!',
            ], 200
        );
    }
}
