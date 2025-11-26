<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->notifications()->latest();

        // Filter by unread
        if ($request->filter == 'unread') {
            $query->whereNull('read_at');
        }

        $notifications = $query->paginate(20);

        return view('admin.notifications', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function markAsUnread($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->update(['read_at' => null]);

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        auth()->user()->notifications()->findOrFail($id)->delete();

        return response()->json(['success' => true]);
    }

    public function clearAll()
    {
        auth()->user()->notifications()->delete();

        return response()->json(['success' => true]);
    }

    public function byType($type)
    {
        $notifications = auth()->user()->notifications()
            ->where('data->type', $type)
            ->latest()
            ->paginate(20);

        return view('admin.notifications', compact('notifications'));
    }
}
