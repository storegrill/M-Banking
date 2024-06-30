@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Accounts</h1>
            <a href="{{ route('accounts.create') }}" class="btn btn-primary mb-3">Create Account</a>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Account Number</th>
                        <th>Balance</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($accounts as $account)
                        <tr>
                            <td>{{ $account->id }}</td>
                            <td>{{ $account->account_number }}</td>
                            <td>{{ $account->balance }}</td>
                            <td>
                                <a href="{{ route('accounts.show', $account->id) }}" class="btn btn-info">View</a>
                                <a href="{{ route('accounts.edit', $account->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('accounts.destroy', $account->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
resources/views/accounts/create.blade.php

blade
Copy code
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Create Account</h1>
            <form action="{{ route('accounts.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="account_number">Account Number</label>
                    <input type="text" name="account_number" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
</div>
@endsection
