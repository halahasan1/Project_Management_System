<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use App\Events\Project\ProjectCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class HandleProjectCreation
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
    public function handle(ProjectCreated $event): void
    {
      Log::info("Project Created: '{$event->project->name}' (ID: {$event->project->id}) by user '{$event->creator->name}' (ID: {$event->creator->id}).");
    }
}
