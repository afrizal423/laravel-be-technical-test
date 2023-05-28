<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UserComments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $data;
    /**
     * Create a new job instance.
     */
    public function __construct(string $user_id, string $news_id)
    {
        $this->data['user_id'] = $user_id;
        $this->data['news_id'] = $news_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        echo json_encode($this->data);
    }
}
