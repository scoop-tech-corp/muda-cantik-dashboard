<?php

namespace App\Http\Controllers;

use App\Models\CommentArticle;
use Illuminate\Http\Request;
use Validator;

class CommentArticleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->role == 'user') {
            return response()->json([
                'message' => 'The user role was invalid.',
                'errors' => ['Access is not allowed!'],
            ], 403);
        }

        $comment = CommentArticle::all();
        return response()->json($comment, 200);
    }

    public function create(Request $request, $id)
    {
        // if ($request->user()->role == 'user') {
        //     return response()->json([
        //         'message' => 'The user role was invalid.',
        //         'errors' => ['Access is not allowed!'],
        //     ], 403);
        // }

        $validate = Validator::make($request->all(), [

            'body' => 'required|min:5',
        ]);

        if ($validate->fails()) {
            $errors = $validate->errors()->all();

            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $errors,
            ], 401);
        }

        $comment = $request->user()->commentarticle()->create([

            'body' => $request->json('body'),
            'article_id' => $id,
            'created_by' => $request->user()->firstname . ' ' . $request->user()->lastname,
        ]);

        return response()->json(
            [
                'message' => 'Success Create Comment Article!',
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

        $comment = CommentArticle::find($id);

        if (is_null($comment)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => ['Data not found!'],
            ], 404);
        }

        return response()->json($comment, 200);
    }

    public function update(Request $request, $id)
    {
        // if ($request->user()->role == 'user') {
        //     return response()->json([
        //         'message' => 'The user role was invalid.',
        //         'errors' => ['Access is not allowed!'],
        //     ], 403);
        // }

        $validate = Validator::make($request->all(), [

            'body' => 'required|min:5',
        ]);

        if ($validate->fails()) {
            $errors = $validate->errors()->all();

            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $errors,
            ], 401);
        }

        $comment = CommentArticle::find($id);

        if (is_null($comment)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => [
                    'data' => ['Data not found!'],
                ]], 404);
        }

        $comment->body = $request->body;
        $comment->update_by = $request->user()->firstname . ' ' . $request->user()->lastname;
        $comment->updated_at = \Carbon\Carbon::now();
        $comment->save();

        return response()->json(
            [
                'message' => 'Success Update Comment Article!',
            ], 200
        );
    }

    public function delete(Request $request, $id)
    {
        // if ($request->user()->role == 'user') {
        //     return response()->json([
        //         'message' => 'The user role was invalid.',
        //         'errors' => ['Access is not allowed!'],
        //     ], 403);
        // }
        
        $comment = CommentArticle::find($id);

        if($comment->user_id != $request->user()->id){
            return response()->json([
                'message' => 'The user role was invalid.',
                'errors' => ['Cannot delete another comment!'],
            ], 403);
        }

        if (is_null($comment)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => ['Data not found!'],
            ], 404);
        }

        $comment->isDeleted = true;
        $comment->deleted_by = $request->user()->firstname . ' ' . $request->user()->lastname;
        $comment->deleted_at = \Carbon\Carbon::now();
        $comment->save();

        $comment->delete();

        return response()->json(
            [
                'message' => 'Success Delete Comment Article!',
            ], 200
        );
    }
}
