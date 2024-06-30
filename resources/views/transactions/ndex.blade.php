@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Transactions</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>From Account</th>
                        <th>To Account</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td>{{ $transaction->from_account }}</td>
                            <td>{{ $transaction->to_account }}</td>
                            <td>{{ $transaction->amount }}</td>
                            <td>{{ $transaction->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
