<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Url;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DeleteInactiveUrls implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $urls = Url::where('updated_at', '<', Carbon::now()->subDays(30))->get();
        $count = $urls->count();
        if ($count > 0) {
            $urls->each->delete();
            Log::info("Deleted {$count} URLs that were not visited in the past 30 days.");
        } else {
            Log::info("No URLs to delete.");
        }
    }
}
