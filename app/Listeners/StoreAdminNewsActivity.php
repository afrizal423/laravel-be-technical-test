<?php

namespace App\Listeners;

use App\Models\Log_news;
use App\Events\NewsHistory;
use Illuminate\Support\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class StoreAdminNewsActivity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewsHistory $event): void
    {
        $userid = $event->user;
        $newsId = $event->news;
        $action = $event->action;
        $current_timestamp = Carbon::now()->toDateTimeString();

        $saved = Log_news::insert([
            'log_description' => $action,
            'news_id' => $newsId,
            'user_id' => $userid,
            'created_at' => $current_timestamp,
            'updated_at' => $current_timestamp
        ]);

    }
}
