<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class VTPassWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();
        Log::info('VTPass Webhook Received', ['payload' => $payload]);

        $requestId = $payload['request_id'] ?? null;
        if (!$requestId) {
            return response()->json(['message' => 'Missing request_id'], 400);
        }

        // Determine status from various possible VTPass webhook structures
        $status = null;
        if (isset($payload['content']['transactions']['status'])) {
            $status = strtolower($payload['content']['transactions']['status']);
        } elseif (isset($payload['status'])) {
            $status = strtolower($payload['status']);
        }

        if (!$status) {
            return response()->json(['message' => 'Missing status in payload'], 200);
        }

        $transaction = Transaction::where('reference', $requestId)->first();

        if (!$transaction) {
            Log::warning("VTPass Webhook: Transaction {$requestId} not found.");
            return response()->json(['message' => 'Transaction not found'], 200);
        }

        if ($transaction->status === 'failed' || $transaction->status === 'refunded') {
            return response()->json(['message' => 'Transaction already processed as failed/refunded'], 200);
        }

        // If the transaction failed, we must refund the user.
        if (in_array($status, ['failed', 'reversed', 'refunded'])) {
            DB::beginTransaction();
            try {
                $transaction->update(['status' => 'failed']);
                
                $user = $transaction->user;
                if ($user && $user->wallet) {
                    $user->wallet->increment('balance', $transaction->amount);
                    
                    // Log the refund as a separate transaction for clarity
                    Transaction::create([
                        'user_id' => $user->id,
                        'reference' => 'REF-' . $requestId,
                        'type' => 'refund',
                        'amount' => $transaction->amount,
                        'status' => 'success',
                        'details' => json_encode(['reason' => 'VTPass transaction failed/reversed via webhook'])
                    ]);

                    Log::info("VTPass Webhook: Refunded {$transaction->amount} to user {$user->id} for failed transaction {$requestId}");
                }
                
                DB::commit();
                return response()->json(['message' => 'Refund processed successfully'], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('VTPass Webhook Refund Error: ' . $e->getMessage());
                return response()->json(['message' => 'Internal Server Error'], 500);
            }
        }

        // If the status is successful, ensure it's marked as success (if it was pending)
        if (in_array($status, ['delivered', 'successful', 'success'])) {
            if ($transaction->status !== 'success') {
                $transaction->update(['status' => 'success']);
                Log::info("VTPass Webhook: Transaction {$requestId} marked as successful.");
            }
        }

        return response()->json(['message' => 'Processed successfully'], 200);
    }
}
