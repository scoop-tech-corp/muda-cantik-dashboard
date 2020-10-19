<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TutorialController extends Controller
{

    public function index()
    {
        return Tutorial::all();
    }

    public function show($id)
    {
        $tutorial = Tutorial::find($id);

        if (is_null($tutorial)) {
            return response()->json(["message" => "Record not found!"], 404);
        }

        return response()->json($tutorial, 200);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
        ]);

        $tutorial = $request->user()->tutorials()->create([
            'title' => $request->json('title'),
            'slug' => Str::slug($request->json('title')),
            'body' => $request->json('body'),
        ]);

        return $tutorial;
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
        ]);

        $tutorial = Tutorial::find($id);

        if ($request->user()->id != $tutorial->user_id) {
            return response()->json(["message" => "Can not edit data!"], 403);
        }

        $tutorial->title = $request->title;
        $tutorial->body = $request->body;
        $tutorial->save();

        return $tutorial;
    }

    public function destroy(Request $request, $id)
    {

        $tutorial = Tutorial::find($id);

        if ($request->user()->id != $tutorial->user_id) {
            return response()->json(["message" => "Can not edit data!"], 403);
        }

        $tutorial->delete();

        return $tutorial;
    }
}
