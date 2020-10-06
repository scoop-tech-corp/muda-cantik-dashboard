<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tags;

class TagsController extends Controller
{
    public function index()
    {
        return Tags::all();
    }

    public function tag_only()
    {
        return Tags::select('TagsName')->get();
    }

    public function create(request $request)
    {
        $cat = new Categories;
        $cat->CategoriesName = $request->catname;
        $cat->Description = $request->desc;
        $cat->Slug = $request->slg;
        $cat->Message = $request->msg;
        $cat->created_by = "agus";
        $cat->update_by = "";
        $cat->deleted_by = "";

        $cat->save();

        return "Success Create";
    }
}
