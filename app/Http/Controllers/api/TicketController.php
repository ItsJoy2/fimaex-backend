<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\TicketAttachment;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index()
    {
        return Ticket::with('messages.attachments')->where('user_id', Auth::id())->get();
    }

    public function create(Request $request)
    {
        $request->validate([
            'subject' => 'required|string',
            'message' => 'nullable|string',
            'attachments.*' => 'file|max:2048',
        ]);

        $ticket = Ticket::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'status' => 'open'
        ]);

        $message = $ticket->messages()->create([
            'sender_id' => Auth::id(),
            'message' => $request->message,
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $message->attachments()->create([
                    'file_path' => $file->store('ticket_attachments', 'public'),
                ]);
            }
        }

        return response()->json(['success' => true, 'ticket' => $ticket->load('messages.attachments')]);
    }

    public function show($id)
    {
        return Ticket::with('messages.attachments')->where('user_id', Auth::id())->findOrFail($id);
    }

    public function reply(Request $request, Ticket $ticket)
    {
        if ($ticket->status === 'closed') {
            return response()->json(['error' => 'This ticket is closed. You cannot be replied to.'], 403);
        }

        $request->validate([
            'message' => 'required|string',
            'attachments.*' => 'file|max:2048',
        ]);

        $message = $ticket->messages()->create([
            'sender_id' => Auth::id(),
            'message' => $request->message,
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $message->attachments()->create([
                    'file_path' => $file->store('ticket_attachments', 'public'),
                ]);
            }
        }

        return response()->json(['message' => $message->load('attachments')]);
    }

    public function resolve(Ticket $ticket)
{
    if ($ticket->user_id !== Auth::id()) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $ticket->status = 'closed';
    $ticket->save();

    return response()->json(['success' => true, 'message' => 'Ticket marked as resolved.']);
}


}
