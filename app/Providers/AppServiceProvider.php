<?php

namespace App\Providers;

use App\Events\CommentCreated;
use App\Events\TaskAssigned;
use App\Listeners\NotifyTaskOfComment;
use App\Listeners\SendTaskAssignedEmail;
use App\Listeners\SendTaskAssignedNotification;
use App\Models\Project;
use App\Models\Task;
use App\Models\Comment;
use App\Models\Attachment;
use App\Observers\AttachmentObserver;
use App\Observers\TaskObserver;
use App\Policies\ProjectPolicy;
use App\Policies\TaskPolicy;
use App\Policies\CommentPolicy;
use App\Policies\AttachmentPolicy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Task::observe(TaskObserver::class);
        Attachment::observe(AttachmentObserver::class);

    }

    protected $policies = [
        Task::class => TaskPolicy::class,
        Comment::class => CommentPolicy::class,
        Attachment::class => AttachmentPolicy::class,
        Project::class => ProjectPolicy::class,
    ];

    protected $listen = [
        TaskAssigned::class => [
            SendTaskAssignedEmail::class,
            SendTaskAssignedNotification::class
        ],
        CommentCreated::class => [
            NotifyTaskOfComment::class,
        ]
    ];
}
