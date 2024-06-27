<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Fetch and display the dashboard summary.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Fetch accounts belonging to the authenticated user
        $accounts = Account::where('user_id', $user->id)->get();

        // Fetch recent transactions for the user
        $recentTransactions = Transaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Calculate total balance across all accounts
        $totalBalance = $accounts->sum('balance');

        return response()->json([
            'user' => $user,
            'accounts' => $accounts,
            'recent_transactions' => $recentTransactions,
            'total_balance' => $totalBalance,
        ]);
    }

    /**
     * Fetch paginated transactions for a specific account.
     *
     * @param  Request  $request
     * @param  int  $accountId
     * @return \Illuminate\Http\JsonResponse
     */
    public function accountTransactions(Request $request, $accountId)
    {
        // Ensure the account belongs to the authenticated user
        $account = Account::where('id', $accountId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Paginate transactions for the account
        $transactions = Transaction::where('account_id', $account->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Adjust pagination as needed

        return response()->json($transactions);
    }

    /**
     * Fetch summary of transactions for a specific period.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function transactionSummary(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Fetch transactions within the specified date range
        $transactions = Transaction::where('user_id', Auth::id())
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // Calculate summary data (total count, total amount, etc.)
        $totalCount = $transactions->count();
        $totalAmount = $transactions->sum('amount');

        return response()->json([
            'total_count' => $totalCount,
            'total_amount' => $totalAmount,
            'transactions' => $transactions,
        ]);
    }
}
