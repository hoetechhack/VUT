<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportTicketController extends Controller
{
    public function index()
    {
        $tickets = Auth::user()->supportTickets()->latest()->get();
        return view('support.index', compact('tickets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Auth::user()->supportTickets()->create($request->only('subject', 'message'));

        return back()->with('status', 'Your complaint has been submitted. We will get back to you soon.');
    }
}
