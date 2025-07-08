<?php

namespace App\Observers;

use App\Models\Task;
use App\Events\TaskCompleted;

class TaskObserver
{

    public function creating(Task $task): void
    {
        if (is_null($task->status)) {
            $task->status = 'pending';
        }
    }


    public function updated(Task $task): void
    {
        if ($task->isDirty('status') && $task->status === 'completed') {
            event(new TaskCompleted($task));
        }
    }
}
