<?php

namespace App\Listeners;

use App\Events\TaskAssigned;
use App\Mail\TaskAssignedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendTaskAssignedEmail implements ShouldQueue
{
    public function handle(TaskAssigned $event): void
    {
        $task = $event->task;

        Log::info(' Listener: SendTaskAssignedEmail started', [
            'task_id' => $task->id,
        ]);

        if (! $task->assignedUser || ! $task->assignedUser->email) {
            Log::warning(' No assigned user or email found', [
                'task_id' => $task->id,
            ]);
            return;
        }

        try {
            Log::info('📧 Attempting to send email to assigned user', [
                'email' => $task->assignedUser->email,
                'task_name' => $task->name,
            ]);

            Mail::to($task->assignedUser->email)
                ->send(new TaskAssignedMail($task));

            Log::info(' Email sent successfully to assigned user', [
                'task_id' => $task->id,
            ]);

        } catch (\Exception $e) {
            Log::error(' Failed to send task assigned email', [
                'error' => $e->getMessage(),
                'task_id' => $task->id,
            ]);

            throw $e;
        }
    }
}
