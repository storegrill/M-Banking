<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MobileRecharge;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MobileRechargeController extends Controller
{
    /**
     * Display a listing of the user's mobile recharges.
     */
    public function index()
    {
        $recharges = MobileRecharge::where('user_id', Auth::id())->paginate(10); // Pagination by 10 items per page

        return response()->json($recharges);
    }

    /**
     * Store a newly created mobile recharge in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'provider' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Validation failed', 'messages' => $validator->errors()], 422);
        }

        try {
            $recharge = MobileRecharge::create([
                'user_id' => Auth::id(),
                'phone_number' => $request->phone_number,
                'amount' => $request->amount,
                'provider' => $request->provider,
            ]);

            // Assuming there is a service to handle the actual recharge process
            // $rechargeService = new RechargeService();
            // $rechargeService->process($recharge);

            return response()->json($recharge, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to process recharge', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified mobile recharge.
     */
    public function show($id)
    {
        try {
            $recharge = MobileRecharge::where('user_id', Auth::id())->findOrFail($id);
            return response()->json($recharge);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Recharge not found', 'message' => $e->getMessage()], 404);
        }
    }

    /**
     * Update the specified mobile recharge in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'provider' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Validation failed', 'messages' => $validator->errors()], 422);
        }

        try {
            $recharge = MobileRecharge::where('user_id', Auth::id())->findOrFail($id);

            $recharge->phone_number = $request->phone_number;
            $recharge->amount = $request->amount;
            $recharge->provider = $request->provider;
            $recharge->save();

            return response()->json($recharge);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update recharge', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified mobile recharge from storage.
     */
    public function destroy($id)
    {
        try {
            $recharge = MobileRecharge::where('user_id', Auth::id())->findOrFail($id);
            $recharge->delete();

            return response()->json(['message' => 'Recharge deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete recharge', 'message' => $e->getMessage()], 500);
        }
    }
}
