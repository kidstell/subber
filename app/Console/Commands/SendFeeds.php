<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Author;
use App\Models\Article;
use App\Models\Subscription;
use Illuminate\Console\Command;

class SendFeeds extends Command
{
    protected $signature = 'feeder {Webkeys?*}';
    protected $description = 'Initiates sending of feeds to Users when there is a new post from authors they are subscribed to. Webkeys are optional';

    public function handle()
    {
        $keys = $this->argument('Webkeys');

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

        if ( ! empty($keys) ){
            $feeds->whereIn("{$au}.key", $keys);
        }
        
        $feeds = $feeds->get();

        dd($feeds);
    }
}
