<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Jobs\DeleteInactiveUrls;

class CleanUpUrls  extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'url:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete URLs that were not visited in the past 30 days';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        dispatch((new DeleteInactiveUrls)->onQueue('high'));

        return Command::SUCCESS;
    }
}
