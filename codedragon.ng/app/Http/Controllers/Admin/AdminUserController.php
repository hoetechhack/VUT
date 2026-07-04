<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $transactions = $user->transactions()->latest()->paginate(10);
        $totalSpend = $user->transactions()->where('status', 'success')->sum('amount');
        $walletBalance = $user->wallet ? $user->wallet->balance : 0;
        
        return view('admin.users.show', compact('user', 'transactions', 'totalSpend', 'walletBalance'));
    }

    public function toggleActive(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'enabled' : 'disabled';
        return back()->with('status', "User account has been {$status}.");
    }

    public function verify(User $user)
    {
        $user->update(['is_verified' => true]);

        // Automatically generate virtual account on admin approval
        if ($user->wallet && !$user->wallet->virtual_account_number) {
            try {
                $monnify = new \App\Services\MonnifyService();
                $ref = 'CT-VA-' . $user->id . '-' . time();
                // Bypass Sandbox R42 strict email collision by making emails unique locally
                $monnifyEmail = config('app.env') === 'local' ? 'sb_' . time() . '_' . $user->email : $user->email;
                
                $res = $monnify->createVirtualAccount($user->name, $monnifyEmail, $ref);
                
                if ($res && isset($res['accounts']) && count($res['accounts']) > 0) {
                    $user->wallet->update([
                        'virtual_account_number' => $res['accounts'][0]['accountNumber'],
                        'virtual_bank_name' => $res['accounts'][0]['bankName'],
                        'virtual_account_name' => $user->name
                    ]);
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Admin Auto-VA Failed: ' . $e->getMessage());
            }
        }

        return back()->with('status', 'User account has been verified and virtual account generated.');
    }

    public function unverify(User $user)
    {
        // Admin can unverify if it's not compulsory or if they want to override
        $user->update([
            'is_verified' => false,
            'bvn_verified_at' => null
        ]);
        return back()->with('status', 'User account has been unverified.');
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password)
        ]);

        return back()->with('status', 'User password updated successfully.');
    }

    public function addBalance(Request $request, User $user)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        if ($user->wallet) {
            $user->wallet->increment('balance', $request->amount);
            
            // Log transaction
            $user->transactions()->create([
                'type' => 'funding',
                'amount' => $request->amount,
                'status' => 'success',
                'description' => 'Manual balance added by admin.',
                'reference' => 'ADM-FUND-' . time(),
            ]);

            return back()->with('status', "₦" . number_format($request->amount, 2) . " added to {$user->name}'s wallet.");
        }

        return back()->with('status', 'Error: User does not have a wallet.');
    }
}
