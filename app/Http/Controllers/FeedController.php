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

        $su = (new Subscription())->getTable();
        $au = (new Author())->getTable();
        $us = (new User())->getTable();
        $ar = (new Article())->getTable();

        $feeds = Subscription::select([
            "{$su}.created_at", "{$ar}.created_at", "{$au}.website", "{$ar}.title", "{$ar}.body", "{$us}.name", "{$us}.email"
        ])
        ->leftJoin("{$au}", "{$au}.id", "=", "{$su}.author_id")
        ->leftJoin("{$us}", "{$us}.id", "=", "{$su}.user_id")
        ->leftJoin("{$ar}", "{$ar}.author_id", "=", "{$su}.author_id");

        if ( ! empty($websiteKeys) ){
            $feeds->whereIn("{$au}.key", $websiteKeys);
        }
        
        return $feeds->get();
    }
}
