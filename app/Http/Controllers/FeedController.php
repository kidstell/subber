<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Author;
use App\Models\Article;
use Illuminate\Support\Arr;
use App\Models\Subscription;

class FeedController extends Controller
{
    static function feedsQuery() {

        $subscriptions = (new Subscription())->getTable();
        $authors = (new Author())->getTable();
        $users = (new User())->getTable();
        $articles = (new Article())->getTable();

        $feeds = Subscription::select([
            "{$articles}.id AS article_id", "{$articles}.created_at AS published_at", "{$articles}.title", "{$articles}.body AS body", "{$users}.id AS user_id", "{$users}.name", "{$users}.email", "{$authors}.id AS author_id", "{$authors}.website"
        ])
        ->leftJoin("{$authors}", "{$authors}.id", "=", "{$subscriptions}.author_id")
        ->leftJoin("{$users}", "{$users}.id", "=", "{$subscriptions}.user_id")
        ->leftJoin("{$articles}", "{$articles}.author_id", "=", "{$subscriptions}.author_id");
        
        return $feeds;
    }

    static function getFeeds() {
        return self::feedsQuery()->get();
    }

    static function getFeedsByAuthorKeys(Array|String $authorKeys=null) {

        $feeds = self::feedsQuery();

        $authorKeys = Arr::wrap($authorKeys);
        
        if ( ! empty($authorKeys) ){
            $authors = (new Author())->getTable();
            $feeds->whereIn("{$authors}.key", $authorKeys);
        }
        
        return $feeds->get();
    }

    static function getFeedsByArticleId($articleId) {

        $feeds = self::feedsQuery();
        
        $article = (new Article())->getTable();

        $feeds->where("{$article}.id", $articleId);

        return $feeds->get();
    }
}