<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->latest()
            ->paginate(15);
        
        return view('notifications.index', compact('notifications'));
    }

    public function marquerLu(string $id)
    {
        $notification = Notification::where('user_id', auth()->id())
            ->findOrFail($id);
        
        $notification->marquerCommeLu();
        
        return response()->json([
            'success' => true,
            'message' => 'Notification marquée comme lue'
        ]);
    }

    public function count()
    {
        $count = auth()->user()
            ->notifications()
            ->nonLues()
            ->count();
        
        return response()->json([
            'count' => $count
        ]);
    }
}