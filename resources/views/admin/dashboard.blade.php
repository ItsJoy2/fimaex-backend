@extends('admin.layouts.app')
@section('content')
    <div class="container mt-4">

        {{-- Pending Withdrawals Alert --}}
        @if($dashboardData['pendingWithdrawals'] > 0)
            <a href="/withdraw" class="text-decoration-none">
                <div class="alert alert-warning d-flex align-items-center shadow-sm rounded p-3 mb-4">
                    <i class="fas fa-exclamation-triangle text-dark fs-4 me-3"></i>
                    <div class="fw-semibold text-dark">
                        You currently have {{ $dashboardData['pendingWithdrawalsCount'] }} pending withdrawal {{ $dashboardData['pendingWithdrawalsCount'] > 1 ? 'requests' : 'request' }}.
                    </div>
                </div>
            </a>
        @endif

        {{-- Users Section --}}
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-4">User Overview</h5>
                <div class="row g-4">

                    @php
                        $users = [
                            ['label' => 'Total Users', 'value' => $dashboardData['totalUser'], 'icon' => 'fas fa-user', 'bg' => 'bg-success'],
                            ['label' => 'Active Users', 'value' => $dashboardData['Total Founders'], 'icon' => 'fas fa-users-cog', 'bg' => 'bg-warning'],
                            ['label' => 'Blocked Users', 'value' => $dashboardData['blockUser'], 'icon' => 'fas fa-user-slash', 'bg' => 'bg-danger'],
                            ['label' => 'New Users', 'value' => $dashboardData['newUser'], 'icon' => 'fas fa-user-plus', 'bg' => 'bg-primary'],
                        ];
                    @endphp

                    @foreach ($users as $user)
                        <div class="col-md-3">
                            <div class="d-flex justify-content-between align-items-center border rounded p-3 h-100 bg-light hover-shadow">
                                <div class="d-flex align-items-center">
                                    <div class="icon-box {{ $user['bg'] }} bg-opacity-75 text-white rounded d-flex justify-content-center align-items-center me-3" style="width: 48px; height: 48px;">
                                        <i class="{{ $user['icon'] }}"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold fs-5">{{ $user['value'] }}</div>
                                        <small class="text-muted">{{ $user['label'] }}</small>
                                    </div>
                                </div>
                              <a href="/users"> <i class="fas fa-arrow-right text-muted"></i></a>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </div>

        {{-- Deposits Section --}}
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-4">Deposits</h5>
                <div class="row g-4">
                    <x-dashboard.stat-card icon="fas fa-hand-holding-usd" value="${{$dashboardData['totalDeposits']}} USD" label="Total Deposited" bg="success" />
                    <x-dashboard.stat-card icon="fas fa-clock" value="{{$dashboardData['pendingDeposits']}}" label="Pending Deposits" bg="warning" />
                    <x-dashboard.stat-card icon="fas fa-times-circle" value="{{$dashboardData['rejectedDeposits']}}" label="Rejected Deposits" bg="danger" />
                    <x-dashboard.stat-card icon="fas fa-percent" value="$0.00 USD" label="Deposited Charge" bg="secondary" />
                </div>
            </div>
        </div>

        {{-- Withdrawals Section --}}
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-4">Withdrawals</h5>
                <div class="row g-4">
                    <x-dashboard.stat-card icon="fas fa-credit-card" value="${{$dashboardData['totalWithdrawals']}}" label="Total Withdrawn" bg="success" />
                    <x-dashboard.stat-card icon="fas fa-clock" value="${{$dashboardData['pendingWithdrawals']}}" label="Pending Withdrawals" bg="warning" />
                    <x-dashboard.stat-card icon="fas fa-times-circle" value="${{$dashboardData['rejectedWithdrawals']}}" label="Rejected Withdrawals" bg="danger" />
                    <x-dashboard.stat-card icon="fas fa-percent" value="${{$dashboardData['totalCharges']}}" label="Withdrawal Charge" bg="secondary" />
                </div>
            </div>
        </div>

        {{-- Investment Section --}}
        {{-- <div class="card shadow-sm mb-4 border-0">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-4">Investments</h5>
                <div class="row g-4">
                    <x-dashboard.stat-card icon="fas fa-coins" value="${{ number_format($dashboardData['totalInvestmentAmount'], 2) }}" label="Total Investment" bg="primary" />
                    <x-dashboard.stat-card icon="fas fa-play-circle" value="${{ number_format($dashboardData['runningInvestmentAmount'], 2) }}" label="Running Investment" bg="success" />
                    <x-dashboard.stat-card icon="fas fa-ban" value="${{ number_format($dashboardData['canceledInvestmentAmount'], 2) }}" label="Canceled Investment" bg="danger" />
                    <x-dashboard.stat-card icon="fas fa-hourglass-end" value="$0" label="Expired Investment" bg="warning" />
                </div>
            </div>
        </div> --}}


    </div>
@endsection
