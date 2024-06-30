@extends('layouts.app')

@section('content')
    <h1>Transfer to Foreign Account</h1>

    <form action="{{ route('foreign.transfer') }}" method="POST">
        @csrf
        <input type="number" name="amount" placeholder="Amount">
        <input type="text" name="foreign_account" placeholder="Foreign Account">
        <input type="text" name="currency" placeholder="Currency (e.g., EUR)">
        <button type="submit">Transfer</button>
    </form>
@endsecti
