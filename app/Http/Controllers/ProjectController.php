<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProjectController extends Controller
{

    public function index()
    {
        try {
            $userId = Auth::id();

            $projects = Project::where('user_id', $userId)->get();

            return Inertia::render('Project/Index', [
                'projectAll' => $projects
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Failed to fetch projects.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            $userId = Auth::id();
            $project = Project::create([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'] ?? null,
                'user_id' => $userId
            ]);

            return response()->json([
                'message' => 'Project created successfully!',
                'project' => $project
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create the project.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

public function show($id)
{
    try {
        $userId = Auth::id();

        $project = Project::where('id', $id)
            ->where('user_id', $userId)
            ->with(['boards.tickets'])
            ->firstOrFail();

        return Inertia::render('Project/Details', [
            'project' => $project,
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to fetch the project.',
            'error' => $e->getMessage()
        ], 404);
    }
}

public function destroy($id, Request $request)
{
    $project = Project::where('id', $id)->first();

    if (!$project) {
        return response()->json(['message' => 'Project not found'], 404);
    }

    if ($project->user_id !== $request->user()->id) {
        return response()->json([
            'message' => 'You are not allowed to delete this project',
            'project_user_id' => $project->user_id,
            'authenticated_user_id' => $request->user()->id,
        ], 403);
    }

    try {
        $project->delete();
        return response()->json(['message' => 'Project deleted successfully!'], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to delete the project.', 'error' => $e->getMessage()], 500);
    }
}

public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    try {
        $userId = Auth::id();

        $project = Project::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();

        $project->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'] ?? null,
        ]);

        return response()->json([
            'message' => 'Project updated successfully!',
            'project' => $project,
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to update the project.',
            'error' => $e->getMessage(),
        ], 500);
    }
}
}
