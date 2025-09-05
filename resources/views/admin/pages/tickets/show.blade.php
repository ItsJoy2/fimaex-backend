@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Ticket #{{ $ticket->ticket_id }} - {{ $ticket->subject ?? 'Support Request' }}</h4>
        <form action="{{ route('admin.tickets.close', $ticket->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to close this ticket?');">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm">Close Ticket</button>
        </form>
    </div>

    <div class="card-body">
        <div class="mb-4">
            <strong>Status:</strong>
            <span class="badge {{ $ticket->status === 'closed' ? 'bg-danger' : 'bg-success' }}">
                {{ ucfirst($ticket->status) }}
            </span>
        </div>

        <div class="border p-3 mb-4" style="background: #f9f9f9;">
            <strong>User:</strong> {{ $ticket->user->name ?? 'N/A' }} <br>
            <strong>Email:</strong> {{ $ticket->user->email ?? 'N/A' }}
        </div>

        <h5 class="mb-3">Conversation</h5>

        <div class="border p-3 mb-4" style="max-height: 400px; overflow-y: auto;">
            @foreach ($ticket->messages as $message)
                <div class="mb-4">
                    <div class="fw-bold">
                        {{ $message->sender->name ?? 'Unknown' }}
                        <small class="text-muted">({{ $message->created_at->format('d M Y, h:i A') }})</small>
                    </div>
                    <p>{{ $message->message }}</p>

                    @if ($message->attachments && $message->attachments->count() > 0)
                        <div class="mb-2">
                            <strong>Attachments:</strong>
                            <ul>
                                @foreach ($message->attachments as $attachment)
                                    <li>
                                        <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank">View Attachment</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <hr>
                </div>
            @endforeach
        </div>

        <h5 class="mb-3">Reply</h5>

        <form action="{{ route('admin.tickets.reply', $ticket->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="message" class="form-label">Your Message</label>
                <textarea name="message" class="form-control" rows="4" required>{{ old('message') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="attachments" class="form-label">Attachments (optional)</label>
                <input type="file" name="attachments[]" multiple class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Send Reply</button>
        </form>
    </div>
</div>
@endsection
