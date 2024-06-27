<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function index()
    {
        $budgets = Budget::where('user_id', Auth::id())->get();
        return response()->json($budgets);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        $budget = Budget::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'amount' => $request->amount,
        ]);

        return response()->json($budget, 201);
    }

    public function show($id)
    {
        $budget = Budget::findOrFail($id);

        // Check if the budget belongs to the authenticated user
        if ($budget->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($budget);
    }

    public function update(Request $request, $id)
    {
        $budget = Budget::findOrFail($id);

        // Check if the budget belongs to the authenticated user
        if ($budget->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        $budget->name = $request->name;
        $budget->amount = $request->amount;
        $budget->save();

        return response()->json($budget);
    }

    public function destroy($id)
    {
        $budget = Budget::findOrFail($id);

        // Check if the budget belongs to the authenticated user
        if ($budget->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $budget->delete();

        return response()->json(['message' => 'Budget deleted']);
    }
}
