<?php
namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\TeamService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Team\StoreTeamRequest;
use App\Http\Requests\Team\UpdateTeamRequest;

class TeamController extends Controller
{
    public function __construct(protected TeamService $teamService)
    {
    }

    /**
     * Get all teams.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $teams = $this->teamService->getAllTeams();

        return $this->successResponse(
            ['teams' => $teams],
            'Teams retrieved successfully'
        );
    }

    /**
     * Create a new team.
     *
     * @param StoreTeamRequest $request
     * @return JsonResponse
     */
    public function store(StoreTeamRequest $request): JsonResponse
    {
        $team = $this->teamService->createTeam($request->validated());

        return $this->successResponse(
            ['team' => $team],
            'Team created successfully',
            201
        );
    }

    /**
     * Update a team.
     *
     * @param UpdateTeamRequest $request
     * @param Team $team
     * @return JsonResponse
     */
    public function update(UpdateTeamRequest $request, Team $team): JsonResponse
    {
        $this->authorize('update', $team);

        $updated = $this->teamService->updateTeam($team, $request->validated());

        return $this->successResponse(
            ['team' => $updated],
            'Team updated successfully'
        );
    }

    /**
     * Delete a team.
     *
     * @param Team $team
     * @return JsonResponse
     */
    public function destroy(Team $team): JsonResponse
    {
        $this->ensureAuthorized('delete-team');
        $this->authorize('delete', $team);

        $this->teamService->deleteTeam($team);

        return $this->successResponse(
            [],
            'Team deleted successfully'
        );
    }

    /**
     * Add a user to a team.
     *
     * @param Request $request
     * @param Team $team
     * @return JsonResponse
     */
    public function addMember(Request $request, Team $team): JsonResponse
    {
        $this->ensureAuthorized('manage-team-members');
        $this->authorize('manageMembers', $team);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($validated['user_id']);

        $this->teamService->addMember($team, $user);

        return $this->successResponse(
            [],
            'User added to the team successfully'
        );
    }

    /**
     * Remove a user from a team.
     *
     * @param Request $request
     * @param Team $team
     * @return JsonResponse
     */
    public function removeMember(Request $request, Team $team): JsonResponse
    {
        $this->ensureAuthorized('manage-team-members');
        $this->authorize('manageMembers', $team);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($validated['user_id']);

        $this->teamService->removeMember($team, $user);

        return $this->successResponse(
            [],
            'User removed from the team successfully'
        );
    }

    /**
     * Helper method to ensure the user has the given ability.
     *
     * @param string $ability
     * @return void
     */
    public function ensureAuthorized(string $ability): void
    {
        if (!Auth::user()->can($ability)) {
            abort(403, "Unauthorized to perform this action: $ability.");
        }
    }

}
