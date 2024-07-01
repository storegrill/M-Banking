<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

abstract class Controller extends BaseController
{
    /**
     * Standard JSON response helper.
     *
     * @param mixed $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResponse($data, $status = 200)
    {
        return response()->json($data, $status);
    }

    /**
     * Register a new user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return $this->jsonResponse(['message' => 'User registered successfully'], 201);
        } catch (\Exception $e) {
            return $this->jsonResponse(['message' => 'Failed to register user', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Log in a user and issue a token for API authentication.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            return $this->jsonResponse([
                'token' => $user->createToken('auth_token')->plainTextToken,
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return $this->jsonResponse(['message' => 'Failed to log in user', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Log out the authenticated user by revoking their current access token.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return $this->jsonResponse(['message' => 'Logged out successfully']);
        } catch (\Exception $e) {
            return $this->jsonResponse(['message' => 'Failed to log out user', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Create a new account for the authenticated user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createAccount(Request $request)
    {
        try {
            $request->validate([
                'account_number' => 'required|string|unique:accounts',
            ]);

            $account = Account::create([
                'user_id' => Auth::id(),
                'account_number' => $request->account_number,
                'balance' => 0.00,
            ]);

            return $this->jsonResponse($account, 201);
        } catch (\Exception $e) {
            return $this->jsonResponse(['message' => 'Failed to create account', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get all accounts belonging to the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAccounts()
    {
        try {
            $accounts = Account::where('user_id', Auth::id())->get();
            return $this->jsonResponse($accounts);
        } catch (\Exception $e) {
            return $this->jsonResponse(['message' => 'Failed to fetch accounts', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Transfer funds between accounts.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function transfer(Request $request)
    {
        try {
            $request->validate([
                'from_account' => 'required|string|exists:accounts,account_number',
                'to_account' => 'required|string|exists:accounts,account_number',
                'amount' => 'required|numeric|min:0.01',
            ]);

            $fromAccount = Account::where('account_number', $request->from_account)->first();
            $toAccount = Account::where('account_number', $request->to_account)->first();

            if (!$fromAccount || !$toAccount) {
                throw new \Exception('One or both accounts not found.');
            }

            if ($fromAccount->balance < $request->amount) {
                return $this->jsonResponse(['message' => 'Insufficient funds'], 400);
            }

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

                DB::commit();

                return $this->jsonResponse(['message' => 'Transfer successful']);
            } catch (\Exception $e) {
                DB::rollback();
                return $this->jsonResponse(['message' => 'Transfer failed', 'error' => $e->getMessage()], 500);
            }
        } catch (\Exception $e) {
            return $this->jsonResponse(['message' => 'Failed to transfer funds', 'error' => $e->getMessage()], 500);
        }
    }
}
