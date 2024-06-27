<!-- resources/views/home.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Welcome, {{ Auth::user()->name }}</h1>

        <div class="card">
            <div class="card-header">Your Accounts</div>
            <div class="card-body">
                @if ($accounts->isEmpty())
                    <p>You don't have any accounts yet. <a href="{{ route('create-account') }}">Create an account</a>.</p>
                @else
                    <ul>
                        @foreach ($accounts as $account)
                            <li>{{ $account->account_number }} - Balance: ${{ $account->balance }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endsection
