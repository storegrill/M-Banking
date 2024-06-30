@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Dashboard</h1>
            <p>Welcome, {{ Auth::user()->name }}!</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Accounts</div>
                <div class="card-body">
                    <a href="{{ route('accounts.index') }}" class="btn btn-primary">View Accounts</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Transactions</div>
                <div class="card-body">
                    <a href="{{ route('transactions.index') }}" class="btn btn-primary">View Transactions</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Exchange Rates</div>
                <div class="card-body">
                    <a href="{{ route('exchange.index') }}" class="btn btn-primary">View Exchange Rates</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
