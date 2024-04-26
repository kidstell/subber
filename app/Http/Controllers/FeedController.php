<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Author;
use App\Models\Article;
use App\Models\Subscription;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    static function getFeeds($websiteKeys) {

        $subscriptions = (new Subscription())->getTable();
        $authors = (new Author())->getTable();
        $users = (new User())->getTable();
        $articles = (new Article())->getTable();

        $feeds = Subscription::select([
            "{$subscriptions}.created_at", "{$articles}.created_at", "{$authors}.website", "{$articles}.title", "{$articles}.body", "{$users}.name", "{$users}.email"
        ])
        ->leftJoin("{$authors}", "{$authors}.id", "=", "{$subscriptions}.author_id")
        ->leftJoin("{$users}", "{$users}.id", "=", "{$subscriptions}.user_id")
        ->leftJoin("{$articles}", "{$articles}.author_id", "=", "{$subscriptions}.author_id");

        if ( ! empty($websiteKeys) ){
            $feeds->whereIn("{$authors}.key", $websiteKeys);
        }
        
        return $feeds->get();
    }
}
