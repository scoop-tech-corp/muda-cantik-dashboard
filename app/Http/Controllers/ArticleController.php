<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

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
                'errors' => ['Access is not allowed!'],
                ], 403);
        }

        $validate = Validator::make($request->all(), [
            'title' => 'required|unique:articles',
            'body' => 'required',
            'gallery_id' => 'required',
            'category_id' => 'required',
            'tag' => 'required',
        ]);

        if ($validate->fails()) {
            $errors = $validate->errors()->all();

            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $errors,
            ], 401);
        }

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
        if ($request->user()->role == 'user') {

            return response()->json([
                'message' => 'The user role was invalid.',
                'errors' => ['Access is not allowed!'],
                ], 403);
        }

        $validate = Validator::make($request->all(), [
            'title' => 'required|unique:articles',
            'body' => 'required',
            'gallery_id' => 'required',
            'category_id' => 'required',
            'tag' => 'required',
        ]);

        if ($validate->fails()) {
            $errors = $validate->errors()->all();

            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $errors,
            ], 401);
        }

        $article = Article::find($id);

        if (is_null($article)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => [
                    'data' => ['Data not found!'],
                ]], 404);
        }

        $article->title = $request->title;
        $article->body = $request->body;
        $article->gallery_id = $request->gallery_id;
        $article->category_id = $request->category_id;
        $article->update_by = $request->user()->firstname . ' ' . $request->user()->lastname;
        $article->updated_at = \Carbon\Carbon::now();
        $article->save();

        $tags = $request->tag;

        $article_detail = ArticleDetail::find($id);

        foreach ($tags as $key) {

            $request->user()->articledetail()->create([

                'tag_id' => $key,
                'article_id' => $article->id,
            ]);
        }
    }

    public function delete(Request $request, $id)
    {
        if ($request->user()->role == 'user') {

            return response()->json([
                'message' => 'The user role was invalid.',
                'errors' => ['Access is not allowed!'],
                ], 403);
        }
    }
}
