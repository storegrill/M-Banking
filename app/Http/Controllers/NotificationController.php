<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the user's notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())->get();
        return response()->json($notifications);
    }

    /**
     * Store a newly created notification in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $notification = Notification::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'body' => $request->body,
            'is_read' => false,
        ]);

        return response()->json($notification, 201);
    }

    /**
     * Mark the specified notification as read.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $notification->is_read = true;
        $notification->save();

        return response()->json(['message' => 'Notification marked as read']);
    }

    /**
     * Remove the specified notification from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notification = Notification::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $notification->delete();

        return response()->json(['message' => 'Notification deleted']);
    }
}
