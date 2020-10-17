<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index()
    {
        return Gallery::all();
    }

    public function images()
    {
        return Gallery::select('categories')->get();
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'imagename' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'required|min:5',
        ]);
    }

    public function getById($id)
    {
        $cat = Categories::find($id);

        if (is_null($cat)) {
            return response()->json(["message" => "Record not found"], 404);
        }

        return response()->json($cat, 200);
    }
}
