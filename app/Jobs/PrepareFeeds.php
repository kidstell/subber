<?php

namespace App\Jobs;

use App\Models\ContentLog;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\FeedController;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
        $feeds = FeedController::getFeedsByArticleId($this->articleId);
        DB::table((new ContentLog)->getTable())->insert($feeds->toArray());
    }
}
