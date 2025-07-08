<?php
 namespace App\Services;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

class TeamService
{
   /**
     * Cache key for storing teams.
     *
     * @var string
     */
    protected string $cacheKey = 'teams';

    /**
     * Get all teams with caching.
     *
     * @return Collection
     */
    public function getAllTeams(): Collection
    {
        return Cache::remember($this->cacheKey, now()->addHours(12), function () {
            return Team::with('owner')->get();
        });
    }

    /**
     * Create a new team.
     *
     * @param array $data
     * @return Team
     */
    public function createTeam(array $data): Team
    {
        $data['owner_id'] = Auth::id();
        $team = Team::create($data);

        if ($team->wasRecentlyCreated) {
            Cache::forget($this->cacheKey);
        }

        return $team;
    }

    /**
     * Update an existing team.
     *
     * @param Team $team
     * @param array $data
     * @return Team
     */
    public function updateTeam(Team $team, array $data): Team
    {
        $team->update($data);

        if ($team->isDirty('name')) {
            Cache::forget($this->cacheKey);
        }

        // Refresh the cache
        Cache::put($this->cacheKey, Team::with('owner')->get(), now()->addHours(1));

        return $team;
    }

    /**
     * Get a team by its ID.
     *
     * @param int $id
     * @return Team
     */
    public function getTeamById(int $id): Team
    {
        return Team::where('id', $id)->with('owner')->firstOrFail();
    }

    /**
     * Delete a team.
     *
     * @param Team $team
     * @return void
     */
    public function deleteTeam(Team $team): void
    {
        $team->delete();
        Cache::forget($this->cacheKey);
    }

    /**
     * Add a member to the team.
     *
     * @param Team $team
     * @param User $user
     * @return void
     */
    public function addMember(Team $team, User $user): void
    {
        $team->members()->attach($user->id);
        Cache::forget($this->cacheKey);
    }

    /**
     * Remove a member from the team.
     *
     * @param Team $team
     * @param User $user
     * @return void
     */
    public function removeMember(Team $team, User $user): void
    {
        $team->members()->detach($user->id);
        Cache::forget($this->cacheKey);
    }

    /**
     * Get the team with the fewest members.
     *
     * @return Team|null
     */
    public function findTeamWithFewestMembers(): ?Team
    {
        return Team::withFewestMembers()->first();
    }

}

