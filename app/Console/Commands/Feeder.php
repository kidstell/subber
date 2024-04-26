<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Author;
use App\Models\Article;
use App\Models\ContentLog;
use App\Models\Subscription;
use Illuminate\Console\Command;
use App\Notifications\NewPostNotification;
use Illuminate\Support\Facades\Notification;

class Feeder extends Command
{
    protected $signature = 'feeder {Webkeys?*}';
    protected $description = 'Initiates sending of feeds to Users when there is a new post from authors they are subscribed to. Webkeys are optional';

    public function handle()
    {
        $messages = ContentLog::where('is_sent', false)
                ->orderBy('article_id', 'asc')
                ->get();

        foreach ($messages as $message) {
            Notification::send($message, new NewPostNotification($message)); // artisan queue:work database
        }
    }
}
