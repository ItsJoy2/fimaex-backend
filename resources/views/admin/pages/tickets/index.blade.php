@extends('admin.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Support Tickets</h4>
        </div>

        <div class="card-body table-responsive">


            <table class="table table-striped table-hover mt-3">
                <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Ticket ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($tickets as $index => $ticket)
                <tr>
                    <td>{{ $index + 1}}</td>
                    <td>#{{ $ticket->ticket_id }}</td>
                    <td>{{ $ticket->user->name ?? 'N/A' }}</td>
                    <td>{{ $ticket->user->email ?? 'N/A' }}</td>
                    <td>{{ $ticket->subject }}</td>
                    <td>
                        <span class="badge bg-{{ $ticket->status == 'open' ? 'success' : 'dark' }}">
                            {{ ucfirst($ticket->status) }}
                        </span>
                    </td>
                    <td>{{ $ticket->created_at->diffForHumans() }}</td>
                    <td>
                        <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn btn-sm btn-primary">View</a>
                    </td>
                </tr>

                @empty
                    <tr>
                        <td colspan="8" class="text-center">No Tickets found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $tickets->withQueryString()->links('admin.layouts.partials.__pagination') }}
            </div>
        </div>
    </div>
@endsection
