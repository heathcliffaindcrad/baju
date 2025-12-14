<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->latest()->paginate(20);
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        
        // User can only mark their own notifications as read
        if ($notification->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $notification->markAsRead();
        
        return redirect()->back()->with('success', 'Notifikasi ditandai sebagai telah dibaca.');
    }

    public function markAllAsRead()
    {
        auth()->user()->notifications()->unread()->update(['is_read' => true]);
        
        return redirect()->back()->with('success', 'Semua notifikasi ditandai sebagai telah dibaca.');
    }

    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        
        // User can only delete their own notifications
        if ($notification->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $notification->delete();
        
        return redirect()->back()->with('success', 'Notifikasi berhasil dihapus.');
    }
}