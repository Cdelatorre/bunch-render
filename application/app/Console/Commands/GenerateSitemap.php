<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\SitemapController;


class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        (new SitemapController())->generateSpatie();
    }
}
