<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AirtimeToCash;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

class AdminAirtimeToCashController extends Controller
{
    public function index()
    {
        $requests = AirtimeToCash::with('user')->latest()->paginate(20);
        return view('admin.airtime-to-cash.index', compact('requests'));
    }

    public function updateStatus(Request $request, AirtimeToCash $atc)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_note' => 'nullable|string',
        ]);

        if ($atc->status !== 'pending') {
            return back()->with('status', 'Error: This request has already been processed.');
        }

        DB::beginTransaction();
        try {
            $atc->status = $request->status;
            $atc->admin_note = $request->admin_note;
            $atc->save();

            if ($request->status === 'approved') {
                // Credit user wallet
                $wallet = Wallet::where('user_id', $atc->user_id)->first();
                $wallet->balance += $atc->receive_amount;
                $wallet->save();

                // Create transaction record
                Transaction::create([
                    'user_id' => $atc->user_id,
                    'type' => 'funding',
                    'amount' => $atc->receive_amount,
                    'status' => 'success',
                    'reference' => $atc->reference,
                    'details' => json_encode(['description' => 'Airtime to Cash conversion approved.']),
                ]);
            }

            DB::commit();
            return back()->with('status', 'Request ' . $request->status . ' successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('status', 'Error: ' . $e->getMessage());
        }
    }
}
