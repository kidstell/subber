<?php

namespace App\Jobs;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\NewPostNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;

class PrepareFeeds implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // protected $connection = 'database';

    /**
     * Create a new job instance.
     */
    public function __construct(protected $articleId, protected $authorId)
    {
        $this->onConnection('database');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $article = Article::find($this->articleId);
        $subscribers = $article->subscribers()->get();

        foreach ($subscribers as $subscriber){
            Notification::send($subscriber, new NewPostNotification($article)); // artisan queue:work database
        }
    }
}
