<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use App\Events\Project\ProjectUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class HandleProjectUpdates
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
    public function handle(ProjectUpdated $event): void
    {
       $changesString = http_build_query($event->changes, '', ', ');

        Log::info("Project Updated: '{$event->project->name}' (ID: {$event->project->id}) by user '{$event->updater->name}'. Changes: [{$changesString}]");

    }
}
