<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DigitalWallet;
use Illuminate\Support\Facades\Auth;

class DigitalWalletController extends Controller
{
    public function show()
    {
        $wallet = Auth::user()->digitalWallet;
        return view('wallet.show', compact('wallet'));
    }

    public function deposit(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:1']);
        $wallet = Auth::user()->digitalWallet;
        $wallet->balance += $request->amount;
        $wallet->save();
        return redirect()->back()->with('success', 'Amount deposited successfully.');
    }

    public function withdraw(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:1']);
        $wallet = Auth::user()->digitalWallet;
        if ($wallet->balance < $request->amount) {
            return redirect()->back()->with('error', 'Insufficient balance.');
        }
        $wallet->balance -= $request->amount;
        $wallet->save();
        return redirect()->back()->with('success', 'Amount withdrawn successfully.');
    }
}
