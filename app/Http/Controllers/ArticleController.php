<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    function createPostForAuthor(Request $request) {
        $validation = Validator::make($request->all(), [
            'title' => 'bail|required|max:255',
            'body' => 'bail|required|string|min:10'
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        $author = Author::where('key' , $request->author)->first();
        if( is_null($author) ){
            return response()->json('Author\'s key not valid', 401);
        }

        $data = $request->only(['title','body']);
        $author->articles()->create($data);

        return response()->json(["message" => "Your new post has been created successfully."]);
    }
}
