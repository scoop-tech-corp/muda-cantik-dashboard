<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        return Article::all();
    }

    public function getById($id)
    {
        $article = Article::find($id);

        if (is_null($article)) {
            return response()->json(["message" => "Record not found"], 404);
        }

        return response()->json($article, 200);
    }

    public function create(request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
        ]);

        $article = $request->user()->tags()->create([
            'title' => $request->json('title'),
            'body' => $request->json('body'),
            'slug' => Str::slug($request->json('title')),
            'created_by' => $request->json('created_by'),
        ]);

        return response()->json(
            [
                'message' => 'Success Create Article',
            ]
        );
    }

    public function update(Request $request, $id)
    {

    }

    public function delete(Request $request,$id)
    {

    }
}
