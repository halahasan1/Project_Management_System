<?php

namespace App\Events;

use App\Models\Task;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class TaskStatusUpdated
{
    use Dispatchable, SerializesModels;

    public Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }
}
