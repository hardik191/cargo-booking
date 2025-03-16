<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
    public function ajaxcall(Request $request)
    {
        $action = $request->input('action');
        switch ($action) {

            case 'read-notification':
                try {
                    // Validate that notification_id exists
                    if (!$request->has('notification_id')) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Notification ID is required'
                        ], 400);
                    }

                    // Mark the notification as read
                    DB::table('notifications')
                        ->where('id', $request->notification_id)
                        ->update(['read_at' => Carbon::now()->format('Y-m-d H:i:s')]);

                    // Get unread notification count for the authenticated user
                    $unreadCount = count(auth()->user()->unreadNotifications);
                    $unreadCount = $unreadCount > 99 ? '99+' : $unreadCount;

                    return response()->json([
                        'status' => true,
                        'unread_count' => $unreadCount
                    ]);
                } catch (\Exception $e) {
                    // Handle any unexpected errors
                    return response()->json([
                        'status' => false,
                        'message' => 'An error occurred: ' . $e->getMessage()
                    ], 500);
                }
                exit;
        }
    }
}
