<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Inertia\Inertia;

class TicketController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'board_id' => 'required|integer',
            'description' => 'required|string',
            'ranke' => 'required|integer'
        ]);

        try {
            $ticket = Ticket::create([
                'title' => $validatedData['title'],
                'board_id' => $validatedData['board_id'],
                'description' => $validatedData['description'],
                'ranke' => $validatedData['ranke']
            ]);

            return response()->json([
                'message' => 'Ticket created successfully!',
                'ticket' => $ticket
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create the Ticket.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function move(Request $request, $id)
    {
        $validatedData = $request->validate([
            'new_board_id' => 'required|exists:boards,id',
        ]);

        try {
            $ticket = Ticket::findOrFail($id);

            $ticket->update([
                'board_id' => $validatedData['new_board_id'],
            ]);

            return response()->json([
                'message' => 'Ticket moved successfully!',
                'ticket' => $ticket,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to move the ticket.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
