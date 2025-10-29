<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationSubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'endpoint'    => 'required',
            'keys.p256dh' => 'required',
            'keys.auth'   => 'required',
        ]);

        auth()->user()->updatePushSubscription(
            $validated['endpoint'],
            $validated['keys']['p256dh'],
            $validated['keys']['auth']
        );

        return response()->json(['success' => true]);
    }
}
