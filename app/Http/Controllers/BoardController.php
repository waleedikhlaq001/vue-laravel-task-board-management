<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class BoardController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'project_id' => 'required|integer',
        ]);

        try {
            $userId = Auth::id();
            $board = Board::create([
                'title' => $validatedData['title'],
                'project_id' => $validatedData['project_id']
            ]);

            return response()->json([
                'message' => 'Board created successfully!',
                'board' => $board
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create the board.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
