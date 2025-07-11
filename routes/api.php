<?php


use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ProjectController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('login',    [AuthController::class, 'login']);
Route::post('logout', [AuthController::class,'logout']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/projects/active', [ProjectController::class, 'getActiveProjects']);
    Route::post('/projects/{project}/members', [ProjectController::class, 'addMember']);
    Route::post('/teams/{team}/add-member', [TeamController::class, 'addMember']);
    Route::get('/teams/fewest-members', [TeamController::class, 'showWithFewestMembers']);
    Route::apiResource('teams', TeamController::class);
    Route::apiResource('projects', ProjectController::class);
    Route::post('/teams/{team}/remove-member', [TeamController::class, 'removeMember']);
    Route::get('/teams/min-members/{min}', [TeamController::class, 'teamsWithMinMembers']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/teams', [TeamController::class, 'index']);
    Route::post('/teams', [TeamController::class, 'store']);
    Route::patch('/teams/{team}', [TeamController::class, 'update']);
    Route::delete('/teams/{team}', [TeamController::class, 'destroy']);
    Route::post('/teams/{team}/remove-member', [TeamController::class, 'removeMember']);

    // Custom task routes first
    Route::get('tasks/overdue', [TaskController::class, 'overdue']);
    Route::get('tasks/completed', [TaskController::class, 'completed']);
    Route::get('tasks/high-priority', [TaskController::class, 'highPriority']);
    Route::get('tasks/{task}/latest-attachment', [TaskController::class, 'latestAttachment']);

    //Dynamic comment routes
    Route::get('/{type}/{id}/comments', [CommentController::class, 'index']);
    Route::get('/{type}/{id}/comments/count', [CommentController::class, 'count']);
    Route::post('/{type}/{id}/comments', [CommentController::class, 'store']);

    Route::get('/comments/{comment}', [CommentController::class, 'show']);
    Route::patch('/comments/{comment}', [CommentController::class, 'update']);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);


    //Dynamic attachment routes
    Route::post('/{type}/{id}/attachments', [AttachmentController::class, 'store']);
    Route::patch('/attachments/{attachment}', [AttachmentController::class, 'update']);
    Route::get('/attachments/{attachment}', [AttachmentController::class, 'show']);
    Route::get('/attachments/{attachment}/download', [AttachmentController::class, 'download'])->name('attachments.download');
    Route::delete('/attachments/{attachment}', [AttachmentController::class, 'destroy']);


    // Then the resource routes
    Route::apiResource('tasks', TaskController::class);

});

Route::middleware(['auth:sanctum','role:admin'])->group(function () {
   Route::apiResource('users', AdminUserController::class);
    Route::post('users/{user}/toggle', [AdminUserController::class, 'toggleStatus']);
});

