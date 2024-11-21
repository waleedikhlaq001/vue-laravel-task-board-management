<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'board_id' => 'required|integer|exists:boards,id',
            'description' => 'required|string',
            'ranke' => 'required|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        try {
            $ticket = Ticket::create([
                'title' => $validatedData['title'],
                'board_id' => $validatedData['board_id'],
                'description' => $validatedData['description'],
                'ranke' => $validatedData['ranke'],
                'start_date' => $validatedData['start_date'] ?? null,
                'end_date' => $validatedData['end_date'] ?? null,
            ]);

            return response()->json([
                'message' => 'Ticket created successfully!',
                'ticket' => $ticket,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create the ticket.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'ranke' => 'required|integer',
            'board_id' => 'required|exists:boards,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        try {
            $ticket = Ticket::findOrFail($id);

            $ticket->update([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'ranke' => $validatedData['ranke'],
                'board_id' => $validatedData['board_id'],
                'start_date' => $validatedData['start_date'] ?? $ticket->start_date,
                'end_date' => $validatedData['end_date'] ?? $ticket->end_date,
            ]);

            return response()->json([
                'message' => 'Ticket updated successfully!',
                'ticket' => $ticket,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update the ticket.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        $ticket = Ticket::find($id);

        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        try {
            $ticket->delete();
            return response()->json(['message' => 'Ticket deleted successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete the ticket.', 'error' => $e->getMessage()], 500);
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
