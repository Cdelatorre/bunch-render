<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Http\Controllers\SitemapController;

class SitemapGeneration implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * The name of the queue on which to place the job.
     *
     * @var string|null
     */
    public $queue = 'sitemap';

    /**
     * The number of seconds the job may run.
     *
     * @var int|null
     */
    public $timeout = 120;

    /**
     * The number of times the job may be attempted.
     *
     * @var int|null
     */
    public $tries = 3;

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
    public function handle(object $event): void
    {
        (new SitemapController())->generateSpatie();
    }
}
