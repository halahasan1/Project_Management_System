<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\AddMemberRequest;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use App\Models\User;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    public function __construct(protected ProjectService $projectService)
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Retrieve all projects in the system.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $projects = $this->projectService->getAllProjects();

        return $this->successResponse(
            ['projects' => $projects],
            'Projects retrieved successfully'
        );
    }

    /**
     * Store a newly created project.
     *
     * @param StoreProjectRequest $request
     * @return JsonResponse
     */
    public function store(StoreProjectRequest $request): JsonResponse
    {
        $project = $this->projectService->createProject($request->validated(), auth()->user());

        return $this->successResponse(
            ['project' => $project],
            'Project created successfully',
            201
        );
    }

    /**
     * Display a specific project.
     *
     * @param Project $project
     * @return JsonResponse
     */
    public function show(Project $project): JsonResponse
    {
        $this->authorize('view', $project);

        return $this->successResponse(
            ['project' => $project],
            'Project retrieved successfully'
        );
    }

    /**
     * Update the specified project.
     *
     * @param UpdateProjectRequest $request
     * @param Project $project
     * @return JsonResponse
     */
    public function update(UpdateProjectRequest $request, Project $project): JsonResponse
    {
        $this->authorize('update', $project);

        $updatedProject = $this->projectService->updateProject(
            $project,
            $request->validated(),
            auth()->user()
        );

        return $this->successResponse(
            ['project' => $updatedProject],
            'Project updated successfully'
        );
    }

    /**
     * Remove the specified project.
     *
     * @param Project $project
     * @return JsonResponse
     */
    public function destroy(Project $project): JsonResponse
    {
        $this->authorize('delete', $project);

        $this->projectService->deleteProject($project, auth()->user());

        return $this->successResponse(
            [],
            'Project deleted successfully'
        );
    }

    /**
     * Add a member to the project.
     *
     * @param AddMemberRequest $request
     * @param Project $project
     * @return JsonResponse
     */
    public function addMember(AddMemberRequest $request, Project $project): JsonResponse
    {
        $this->authorize('addMember', $project);

        $user = User::findOrFail($request->validated()['user_id']);

        $this->projectService->addMember($project, $user);

        return $this->successResponse(
            [],
            'Member added to project successfully'
        );
    }

    /**
     * Get all active projects associated with the authenticated user.
     *
     * @return JsonResponse
     */
    public function getActiveProjects(): JsonResponse
    {
        $projects = $this->projectService->getActiveProjectsForUser(auth()->user());

        return $this->successResponse(
            ['projects' => $projects],
            'Active projects retrieved successfully'
        );
    }
}
