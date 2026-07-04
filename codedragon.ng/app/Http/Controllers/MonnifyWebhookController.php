<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MonnifyService;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class MonnifyWebhookController extends Controller
{
    public function handle(Request $request, MonnifyService $monnify)
    {
        Log::info('Monnify Webhook Incoming', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'payload' => $request->all(),
            'signature' => $request->header('monnify-signature')
        ]);
        
        $signature = $request->header('monnify-signature');
        $payload = $request->getContent();

        if (!$monnify->verifyWebhookSignature($payload, $signature)) {
            Log::warning('Monnify Webhook: Invalid Signature', ['payload' => $payload]);
            return response()->json(['message' => 'Invalid signature'], 401);
        }

        $data = json_decode($payload, true);
        
        if (!isset($data['eventType']) || $data['eventType'] !== 'SUCCESSFUL_TRANSACTION') {
            return response()->json(['message' => 'Ignored event type'], 200);
        }

        $eventData = $data['eventData'];
        $amountPaid = $eventData['amountPaid'];
        $settlementAmount = $eventData['settlementAmount'];
        $transactionReference = $eventData['transactionReference'];
        
        // Product reference holds the accountReference used when reserving the account
        $accountReference = $eventData['product']['reference'];

        // Prevent processing the same transaction twice
        if (Transaction::where('reference', $transactionReference)->exists()) {
            return response()->json(['message' => 'Transaction already processed'], 200);
        }

        DB::beginTransaction();
        try {
            // Find the wallet by matching the account reference from the DB or by extracting the User ID
            // Since our ref format is 'CT-VA-{user_id}-{timestamp}', we can extract the user_id or search wallets
            
            // However, we don't save account_reference in Wallet. But we can extract user_id:
            $parts = explode('-', $accountReference);
            if (count($parts) >= 3 && $parts[0] === 'CT' && $parts[1] === 'VA') {
                $userId = $parts[2];
                $wallet = Wallet::where('user_id', $userId)->first();
                
                if ($wallet) {
                    $wallet->increment('balance', $settlementAmount);
                    
                    Transaction::create([
                        'user_id' => $userId,
                        'reference' => $transactionReference,
                        'type' => 'funding',
                        'amount' => $settlementAmount,
                        'status' => 'success',
                        'details' => json_encode(['monnify_data' => $eventData])
                    ]);
                    
                    Log::info("Monnify Webhook: Wallet {$wallet->id} funded with {$settlementAmount}");

                    // Send WhatsApp Notification
                    try {
                        $whatsApp = new \App\Services\WhatsAppService();
                        $user = $wallet->user;
                        if ($user && $user->phone) {
                            $whatsApp->sendMessage($user->phone, "💳 *Wallet Funding Successful!*\n\nYour CandyTech wallet has been credited with *₦" . number_format($settlementAmount, 2) . "*.\n\nNew Balance: *₦" . number_format($wallet->balance, 2) . "*");
                        }
                    } catch (\Exception $e) {
                        Log::error("WhatsApp Notification Failed: " . $e->getMessage());
                    }
                } else {
                    Log::error("Monnify Webhook: Wallet not found for User ID {$userId}");
                }
            } else {
                Log::error("Monnify Webhook: Invalid account reference format: {$accountReference}");
            }
            
            DB::commit();
            return response()->json(['message' => 'Success'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Monnify Webhook Error: ' . $e->getMessage());
            return response()->json(['message' => 'Internal Error'], 500);
        }
    }
}
