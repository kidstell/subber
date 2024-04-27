<?php

namespace App\Console\Commands;

use App\Models\ContentLog;
use Illuminate\Console\Command;
use App\Notifications\NewPostNotification;
use Illuminate\Contracts\Console\Isolatable;
use Illuminate\Support\Facades\Notification;

class Feeder extends Command implements Isolatable
{
    protected $signature = 'feeder';
    protected $description = 'Initiates sending of feeds to Users when there is a new post from authors they are subscribed to.';

    public function handle()
    {
        $messages = ContentLog::where('is_sent', false)
                ->orderBy('article_id', 'asc')
                ->get();
        
        $this->comment(count($messages).' pending subscription feeds found');
        $this->comment('Processing...');

        foreach ($messages as $message) {
            Notification::send($message, new NewPostNotification($message)); // artisan queue:work database
        }
        ContentLog::where('is_sent', true)->delete();
        $this->comment('Done');
    }
}
