<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Author;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriberController extends Controller
{
    function subscribeToAuthor(Request $request) {

        $url = $request->input('website');
        $urlParts = parse_url($url);
        if( ! isset($urlParts['scheme']) ){
            $request->merge(['website' => 'https://'.$url]);
        }

        $validation = Validator::make($request->all(), [
            'email' => 'bail|email',
            'website' => 'bail|url:http,https'
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        $subscriber = User::where('email' , strtolower($request->input('email')))->first();
        if( ! $subscriber ){
            return response()->json($request->input('email').' is not a valid user.', 422);
        }

        $author = Author::where('website' , strtolower($request->input('website')))->first();
        if( ! $author ){
            return response()->json($url.' not available for subscription.', 422);
        }

        $subscription = Subscription::firstOrCreate([
            'user_id' => $subscriber->id,
            'author_id' => $author->id,
        ]);

        if ( ! $subscription->wasRecentlyCreated ){
            return response()->json(["message" => "Subscription already exists."]);
        }

        return response()->json(["message" => "Your Subscription was successful."]);
    }
}
