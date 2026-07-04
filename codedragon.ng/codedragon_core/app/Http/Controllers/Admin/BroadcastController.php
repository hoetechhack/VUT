<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\WhatsAppService;

class BroadcastController extends Controller
{
    public function index()
    {
        return view('admin.broadcast.index');
    }

    public function send(Request $request, WhatsAppService $whatsApp)
    {
        $request->validate([
            'message' => 'required|string',
            'target' => 'required|in:all,verified,unverified'
        ]);

        $query = User::query();

        if ($request->target === 'verified') {
            $query->where('is_verified', true);
        } elseif ($request->target === 'unverified') {
            $query->where('is_verified', false);
        }

        $users = $query->whereNotNull('phone')->get();
        $count = 0;

        foreach ($users as $user) {
            // We use the direct sendMessage which checks provider status
            if ($whatsApp->sendMessage($user->phone, $request->message)) {
                $count++;
            }
        }

        return back()->with('status', "Broadcast sent successfully to $count users via WhatsApp!");
    }
}
