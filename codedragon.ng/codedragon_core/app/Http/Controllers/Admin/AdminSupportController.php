<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class AdminSupportController extends Controller
{
    public function index()
    {
        $tickets = SupportTicket::with('user')->latest()->paginate(20);
        return view('admin.support.index', compact('tickets'));
    }

    public function reply(Request $request, SupportTicket $ticket)
    {
        $request->validate(['admin_reply' => 'required']);
        $ticket->update([
            'admin_reply' => $request->admin_reply,
            'status' => 'replied'
        ]);
        return back()->with('status', 'Reply sent to user.');
    }

    public function close(SupportTicket $ticket)
    {
        $ticket->update(['status' => 'closed']);
        return back()->with('status', 'Ticket closed.');
    }
}
