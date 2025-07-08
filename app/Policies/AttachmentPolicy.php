<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Attachment;

class AttachmentPolicy
{
    /**
     * admin has all permissions already
     */
    public function before(User $user, string $ability): bool|null
    {
        return $user->hasRole('admin') ? true : null;
    }

    /**
     * Determine whether the user can view the attachment
     */
    public function view(User $user, Attachment $attachment): bool
    {
        return $user->can('view', $attachment->attachable);
    }

    /**
     * Determine whether the user can update the attachment
     */
    public function update(User $user, Attachment $attachment): bool
    {
        return $user->can('update', $attachment->attachable);
    }

    /**
     * Determine whether the user can delete the attachment
     */
    public function delete(User $user, Attachment $attachment): bool
    {
        return $user->can('update', $attachment->attachable);
    }


}
