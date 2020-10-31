<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $article = Article::with('articlesdetail')->get();

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
        if ($request->user()->role == 'user') {

            return response()->json([
                'message' => 'The user role was invalid.',
                'errors' => [
                    'user' => ['Access is not allowed!'],
                ]], 403);
        }

        $this->validate($request, [
            'title' => 'required|unique:articles',
            'body' => 'required',
            'gallery_id' => 'required',
            'category_id' => 'required',
            'tag' => 'required',
        ]);

        $article = $request->user()->article()->create([
            'title' => $request->json('title'),
            'body' => $request->json('body'),
            'gallery_id' => $request->json('gallery_id'),
            'category_id' => $request->json('category_id'),
            'slug' => Str::slug($request->json('title')),
            'created_by' => $request->user()->firstname . ' ' . $request->user()->lastname,
        ]);

        $tags = $request->tag;

        foreach ($tags as $key) {

            $request->user()->articledetail()->create([

                'tag_id' => $key,
                'article_id' => $article->id,
            ]);
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

    public function delete(Request $request, $id)
    {

    }

    public function getByTag(Request $request)
    {

    }
}
