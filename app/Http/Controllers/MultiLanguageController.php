<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MultiLanguage;

class MultiLanguageController extends Controller
{
    /**
     * Set the preferred language for the authenticated user.
     */
    public function setLanguage(Request $request)
    {
        $request->validate([
            'language' => 'required|string|in:en,fr,es,de,it', // Add supported languages here
        ]);

        $user = Auth::user();
        $multiLanguage = $user->multiLanguage ?? new MultiLanguage(['user_id' => $user->id]);
        $multiLanguage->language = $request->language;
        $multiLanguage->save();

        return response()->json(['message' => 'Language updated successfully']);
    }

    /**
     * Get the preferred language of the authenticated user.
     */
    public function getLanguage()
    {
        $user = Auth::user();
        $language = $user->multiLanguage ? $user->multiLanguage->language : 'en'; // Default to English if not set

        return response()->json(['language' => $language]);
    }
}
