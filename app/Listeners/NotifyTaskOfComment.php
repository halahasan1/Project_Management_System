<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class NotifyTaskOfComment implements ShouldQueue
{
    public function handle(CommentCreated $event): void
    {
        $comment = $event->comment;

        if ($comment->commentable_type !== 'App\\Models\\Task') {
            return;
        }

        $task = $comment->commentable;
        $ownerId = $task->assigned_to_user_id;

        if (! $ownerId) {
            Log::warning(' Task has no assigned user for comment notification', [
                'task_id' => $task->id
            ]);
            return;
        }

        Notification::create([
            'user_id' => $ownerId,
            'type' => 'task_comment',
            'data' => [
                'message' => 'new comment added for the task: ' . $task->name,
                'task_id' => $task->id,
                'comment_id' => $comment->id,
            ]
        ]);

        Log::info(' Notification sent to task owner about new comment', [
            'task_id' => $task->id,
            'comment_id' => $comment->id,
            'user_id' => $ownerId
        ]);
    }
}
