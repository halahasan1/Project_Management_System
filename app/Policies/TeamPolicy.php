<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;

class TeamPolicy
{

    /**
     * Only the owner of the team can update it.
     */
    public function update(User $user, Team $team): bool
    {
        return $user->id === $team->owner_id;
    }

    /**
     * Only the owner can delete the team.
     */
    public function delete(User $user, Team $team): bool
    {
        return $user->id === $team->owner_id;
    }

    /**
     * Only the owner can manage members.
     */
    public function manageMembers(User $user, Team $team): bool
    {
        return $user->id === $team->owner_id;
    }
}
