<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;

class TaskAssignedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function build()
    {
        return $this->subject('a new task assigned to youu' . $this->task->name)
            ->view('emails.task-assigned')
            ->with(['task' => $this->task]);
    }
}
