<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $article = Article::all();
        return response()->json($article, 200);
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

        $article = $request->user()->article()->create([
            'title' => $request->json('title'),
            'body' => $request->json('body'),
            'slug' => Str::slug($request->json('title')),
            'created_by' => $request->json('created_by'),
        ]);

        foreach($article as $key => $value){
            
        }

        return response()->json(
            [
                'message' => 'Success Create Article',
            ], 200
        );
    }

    public function update(Request $request, $id)
    {

    }

    public function delete(Request $request,$id)
    {

    }

    public function getByTag(Request $request)
    {
        
    }
}
