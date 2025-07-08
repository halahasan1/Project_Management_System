<?php
namespace App\Listeners;

use App\Events\TaskAssigned;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendTaskAssignedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(TaskAssigned $event): void
    {
        $task = $event->task;

        Log::info(' Listener: StoreTaskNotification started', [
            'task_id' => $task->id,
        ]);

        if (! $task->assigned_to_user_id) {
            Log::warning(' Notification skipped: no assigned_to_user_id', [
                'task_id' => $task->id,
            ]);
            return;
        }

        try {
            Notification::create([
                'user_id' => $task->assigned_to_user_id,
                'type' => 'task_assigned',
                'data' => [
                    'message' => 'you are asignee to a new task: ' . $task->name,
                    'task_id' => $task->id,
                    'project_id' => $task->project_id,
                ],
            ]);

            Log::info(' Notification stored successfully', [
                'user_id' => $task->assigned_to_user_id,
                'task_id' => $task->id,
            ]);

        } catch (\Exception $e) {
            Log::error(' Failed to store notification', [
                'task_id' => $task->id,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
