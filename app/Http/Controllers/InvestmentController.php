<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Investment;
use Illuminate\Support\Facades\Auth;

class InvestmentController extends Controller
{
    public function index()
    {
        $investments = Investment::where('user_id', Auth::id())->get();
        return response()->json($investments);
    }

    public function show($id)
    {
        $investment = Investment::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        return response()->json($investment);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'maturity_date' => 'nullable|date',
        ]);

        $investment = Investment::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'amount' => $request->amount,
            'maturity_date' => $request->maturity_date,
        ]);

        return response()->json($investment, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'status' => 'required|string',
            'maturity_date' => 'nullable|date',
        ]);

        $investment = Investment::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        $investment->update($request->all());

        return response()->json($investment);
    }

    public function destroy($id)
    {
        $investment = Investment::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        $investment->delete();

        return response()->json(['message' => 'Investment deleted successfully']);
    }
}
