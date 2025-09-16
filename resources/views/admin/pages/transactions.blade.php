

@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">Transactions History</div>
    </div>
    <div class="card-body table-responsive">
        <form action="{{ route('transactions.index') }}" method="GET" class="mb-3 d-flex align-items-center gap-2 flex-wrap">
            <input type="text" name="email" class="form-control w-auto" placeholder="Search by email" value="{{ request('email') }}">

            <select name="remark" class="form-select w-auto">
                <option value="">All Types</option>
                @foreach(['withdrawal','transfer','referral_commission','package_purchased'] as $type)
                    <option value="{{ $type }}" {{ request('remark') == $type ? 'selected' : '' }}>
                        {{ ucwords(str_replace('_', ' ', $type)) }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary">Search</button>

            @if(request()->has('email') || request()->has('remark'))
                <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">Reset</a>
            @endif
        </form>

        <table class="table table-striped table-hover table-head-bg-primary mt-4">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Transaction Type</th>
                    <th scope="col">Description</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $index => $transaction)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $transaction->user->name }}</td>
                    <td>${{ number_format($transaction->amount, 3) }}</td>
                    <td>{{ ucfirst($transaction->remark) }}</td>
                    <td>{{ $transaction->details }}</td>
                    <td>{{ $transaction->status }}</td>
                    <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach

            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $transactions->links('admin.layouts.partials.__pagination') }}
        </div>

    </div>
</div>
@endsection

