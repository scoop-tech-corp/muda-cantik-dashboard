<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Validator;

class CategoriesController extends Controller
{
    public function index()
    {
        return response()->json(Categories::get(), 200);
    }

    public function categories_name()
    {
        return response()->json(Categories::select('CategoriesName')->get(), 200);
    }

    public function create(Request $request)
    {
        $rules = [
            'CategoriesName' => 'required|min:3|max:20',
            'Description' => 'required|min:5'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        $cat = Categories::create($request->all());
        return response()->json($cat, 201);

    }

    public function getById($id)
    {
        $cat = Categories::find($id);
        if(is_null($cat))
        {
            return response()->json(["message" => "Record not found"],404);
        }

        return response()->json($cat,200);
    }

    public function update(request $request, $id)
    {
        $catname = $request->catname;
        $desc = $request->desc;
        $slg = $request->slg;
        $msg = $request->msg;
        $create = $request->create;

        $cat = Categories::find($id);
        $cat->CategoriesName = $catname;
        $cat->Description = $desc;
        $cat->Slug = $slg;
        $cat->Message = $msg;
        $cat->update_by = "budi";
        $cat->deleted_by = "";

        if ($cat->save()) {
            return new CategoriesResource($cat);
        }

    }

    public function delete($id)
    {
        $cat = Categories::find($id);
        $cat->isDeleted = 1;
        $cat->deleted_by = "susi";
        $cat->save();

        if ($cat->delete()) {
            return new CategoriesResource($cat);
        }
    }
}
