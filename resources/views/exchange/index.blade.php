@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Exchange Rates</h1>
            <form action="{{ route('exchange.convert') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="baseCurrency">Base Currency</label>
                    <input type="text" name="baseCurrency" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="targetCurrency">Target Currency</label>
                    <input type="text" name="targetCurrency" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="number" name="amount" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Convert</button>
            </form>
            @if(isset($convertedAmount))
                <h2>Converted Amount: {{ $convertedAmount }}</h2>
            @endif
        </div>
    </div>
</div>
@endsection
