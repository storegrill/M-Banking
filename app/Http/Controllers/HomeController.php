<?php

// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account; // Example model
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Example logic to fetch data
        $user = Auth::user();
        $accounts = $user ? Account::where('user_id', $user->id)->get() : [];

        // Pass data to the view
        return view('home', compact('accounts'));
    }
}
