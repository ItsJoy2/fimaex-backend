<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\TicketAttachment;
use Illuminate\Support\Facades\Auth;

class AdminTicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('user')->latest()->paginate(10);
        return view('admin.pages.tickets.index', compact('tickets'));
    }

    public function show($id)
    {
        $ticket = Ticket::with(['messages.attachments', 'messages.sender'])->findOrFail($id);
        return view('admin.pages.tickets.show', compact('ticket'));
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string',
            'attachments.*' => 'file|max:2048',
        ]);

        $ticket = Ticket::findOrFail($id);

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

        return redirect()->back()->with('success', 'Reply sent successfully');
    }

    public function close($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->status = 'closed';
        $ticket->save();

        return redirect()->back()->with('success', 'Ticket closed');
    }
}
