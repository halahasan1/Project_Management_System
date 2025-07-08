<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'content' => 'nbjknbedjkbnik',
            'user_id' => User::factory(), // Creates and links a user
            'commentable_id' => null,     // To be set explicitly for polymorphic relation
            'commentable_type' => null,   // e.g., App\Models\Project or App\Models\Task
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Helper to assign a commentable model (e.g., Project or Task).
     */
    public function forCommentable($commentable)
    {
        return $this->state(function () use ($commentable) {
            return [
                'commentable_id' => $commentable->id,
                'commentable_type' => get_class($commentable),
            ];
        });
    }
}
