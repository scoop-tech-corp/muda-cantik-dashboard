<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index()
    {
        return Gallery::all();
    }

    public function GetImages()
    {
        return Gallery::select('imagename')->get();
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'imagename' => 'required', //nanti ini akan digunakan ==> |file|image|mimes:jpeg,png,jpg|max:2048
            'imagetype' => 'required',
            'size' => 'required',
            'alternativetext' => 'required',
            'title' => 'required',
            'caption' => 'required',
            'description' => 'required|min:5',
        ]);

        $gallery = $request->user()->galleries()->create([

            'imagename' => $request->json('imagename'),
            'imagetype' => $request->json('imagetype'),
            'size' => $request->json('size'),
            'alternativetext' => $request->json('alternativetext'),
            'title' => $request->json('title'),
            'caption' => $request->json('caption'),
            'description' => $request->json('description'),
            'url' => Str::slug($request->json('imagename')),
            'created_by' => $request->json('created_by'),
        ]);

        // $imagename = $request->json('imagename');

        // $tujuan_upload = 'data_file';
        // $imagename->move($tujuan_upload, $imagename->getClientOriginalName());
        // nanti akan dipakai

        return response()->json(
            [
                'message' => 'Success Upload Image!',
            ]
        );

    }

    public function getById($id)
    {
        $cat = Categories::find($id);

        if (is_null($cat)) {
            return response()->json(["message" => "Record not found"], 404);
        }

        return response()->json($cat, 200);
    }

    public function update(Request $request, $id)
    {
        
    }

    public function delete($id)
    {

    }
}
