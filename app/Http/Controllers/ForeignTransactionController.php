<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Transaction;
use App\Models\DigitalWallet;
use Illuminate\Support\Facades\Auth;

class ForeignTransactionController extends Controller
{
    public function transfer(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'foreign_account' => 'required|string',
            'currency' => 'required|string'
        ]);

        $wallet = Auth::user()->digitalWallet;
        if ($wallet->balance < $request->amount) {
            return redirect()->back()->with('error', 'Insufficient balance.');
        }

        // Get exchange rate
        $rate = $this->getExchangeRate('USD', $request->currency);
        $convertedAmount = $request->amount * $rate;

        // Deduct from wallet
        $wallet->balance -= $request->amount;
        $wallet->save();

        // Create transaction
        Transaction::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'foreign_account' => $request->foreign_account,
            'currency' => $request->currency,
            'exchange_rate' => $rate,
            'converted_amount' => $convertedAmount
        ]);

        return redirect()->back()->with('success', 'Transfer successful.');
    }

    private function getExchangeRate($baseCurrency, $targetCurrency)
    {
        $response = Http::get("https://api.exchangerate-api.com/v4/latest/{$baseCurrency}");
        if ($response->successful()) {
            return $response->json()['rates'][$targetCurrency];
        }
        return 1; // default to 1 if API fails
    }
}
