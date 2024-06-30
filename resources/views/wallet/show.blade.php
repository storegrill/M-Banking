@extends('layouts.app')

@section('content')
    <h1>Digital Wallet</h1>
    <p>Balance: {{ $wallet->balance }}</p>

    <form action="{{ route('wallet.deposit') }}" method="POST">
        @csrf
        <input type="number" name="amount" placeholder="Deposit Amount">
        <button type="submit">Deposit</button>
    </form>

    <form action="{{ route('wallet.withdraw') }}" method="POST">
        @csrf
        <input type="number" name="amount" placeholder="Withdraw Amount">
        <button type="submit">Withdraw</button>
    </form>
@endsection
