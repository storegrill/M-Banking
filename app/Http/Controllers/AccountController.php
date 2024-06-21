<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Ensure DB facade is imported

class AccountController extends Controller
{
    public function createAccount(Request $request)
    {
        $request->validate([
            'account_number' => 'required|string|unique:accounts',
        ]);

        $account = Account::create([
            'user_id' => Auth::id(),
            'account_number' => $request->account_number,
            'balance' => 0.00,
        ]);

        return response()->json($account, 201);
    }

    public function getAccounts()
    {
        $accounts = Account::where('user_id', Auth::id())->get();
        return response()->json($accounts);
    }

    public function transfer(Request $request)
    {
        $request->validate([
            'from_account' => 'required|string|exists:accounts,account_number',
            'to_account' => 'required|string|exists:accounts,account_number',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $fromAccount = Account::where('account_number', $request->from_account)->first();
        $toAccount = Account::where('account_number', $request->to_account)->first();

        if ($fromAccount->balance < $request->amount) {
            return response()->json(['message' => 'Insufficient funds'], 400);
        }

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Perform the transfer
            $fromAccount->balance -= $request->amount;
            $toAccount->balance += $request->amount;

            $fromAccount->save();
            $toAccount->save();

            // Record transactions
            Transaction::create([
                'account_id' => $fromAccount->id,
                'type' => 'debit',
                'amount' => $request->amount,
            ]);

            Transaction::create([
                'account_id' => $toAccount->id,
                'type' => 'credit',
                'amount' => $request->amount,
            ]);

            // Commit the transaction if all went well
            DB::commit();

            return response()->json(['message' => 'Transfer successful']);
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurred
            DB::rollback();
            return response()->json(['message' => 'Transfer failed', 'error' => $e->getMessage()], 500);
        }
    }
}
