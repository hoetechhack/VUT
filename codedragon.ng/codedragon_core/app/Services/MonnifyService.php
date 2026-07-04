<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MonnifyService
{
    protected $baseUrl;
    protected $apiKey;
    protected $secretKey;
    protected $contractCode;

    public function __construct()
    {
        $this->baseUrl = \App\Models\Setting::where('key', 'monnify_base_url')->value('value') ?: 'https://sandbox.monnify.com';
        $this->apiKey = \App\Models\Setting::where('key', 'monnify_api_key')->value('value');
        $this->secretKey = \App\Models\Setting::where('key', 'monnify_secret_key')->value('value');
        $this->contractCode = \App\Models\Setting::where('key', 'monnify_contract_code')->value('value');
    }

    protected function getAccessToken()
    {
        $response = Http::withBasicAuth($this->apiKey, $this->secretKey)
            ->post($this->baseUrl . '/api/v1/auth/login');

        if ($response->successful()) {
            return $response->json()['responseBody']['accessToken'];
        }

        Log::error('Monnify Auth Failed', ['response' => $response->body()]);
        throw new \Exception('Could not authenticate with Monnify');
    }

    public function createVirtualAccount($name, $email, $reference)
    {
        $token = $this->getAccessToken();

        $response = Http::withToken($token)
            ->post($this->baseUrl . '/api/v2/bank-transfer/reserved-accounts', [
                'accountReference' => $reference,
                'accountName' => $name,
                'currencyCode' => 'NGN',
                'contractCode' => $this->contractCode,
                'customerEmail' => $email,
                'getAllAvailableBanks' => true
            ]);

        if ($response->successful()) {
            return $response->json()['responseBody'];
        }

        Log::error('Monnify Virtual Account Creation Failed', ['response' => $response->body()]);
        return null;
    }

    public function verifyWebhookSignature($requestBody, $signature)
    {
        $computedHash = hash_hmac('sha512', $requestBody, $this->secretKey);
        return hash_equals($computedHash, $signature);
    }

    public function verifyBvn($bvn)
    {
        try {
            $token = $this->getAccessToken();

            $response = Http::withToken($token)
                ->post($this->baseUrl . '/api/v1/vas/bvn-details', [
                    'bvn' => $bvn
                ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()['responseBody']
                ];
            }

            return [
                'success' => false,
                'message' => $response->json()['responseMessage'] ?? 'Verification failed'
            ];
        } catch (\Exception $e) {
            Log::error('Monnify BVN Exception', ['error' => $e->getMessage()]);
            return ['success' => false, 'message' => 'Connection to Monnify failed'];
        }
    }

    public function disburse($amount, $bankCode, $accountNumber, $narration, $reference)
    {
        try {
            $token = $this->getAccessToken();

            $response = Http::withToken($token)
                ->post($this->baseUrl . '/api/v2/disbursements/single', [
                    'amount' => $amount,
                    'reference' => $reference,
                    'narration' => $narration,
                    'destinationBankCode' => $bankCode,
                    'destinationAccountNumber' => $accountNumber,
                    'currency' => 'NGN',
                    'sourceAccountNumber' => $this->contractCode
                ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()['responseBody']
                ];
            }

            return [
                'success' => false,
                'message' => $response->json()['responseMessage'] ?? 'Disbursement failed'
            ];
        } catch (\Exception $e) {
            Log::error('Monnify Disbursement Exception', ['error' => $e->getMessage()]);
            return ['success' => false, 'message' => 'Connection to Monnify failed'];
        }
    }

    public function validateAccount($accountNumber, $bankCode)
    {
        try {
            $token = $this->getAccessToken();
            $response = Http::withToken($token)
                ->get($this->baseUrl . '/api/v1/disbursements/account/validate', [
                    'accountNumber' => $accountNumber,
                    'bankCode' => $bankCode
                ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'accountName' => $response->json()['responseBody']['accountName'] ?? 'Unknown Account'
                ];
            }

            return ['success' => false, 'message' => 'Invalid account details'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Lookup failed'];
        }
    }

    public function getWalletBalance()
    {
        try {
            $token = $this->getAccessToken();
            $walletAccount = \App\Models\Setting::where('key', 'monnify_wallet_account')->value('value');
            
            if (!$walletAccount) {
                return ['success' => false, 'message' => 'Wallet account not configured.'];
            }

            $response = Http::withToken($token)
                ->get($this->baseUrl . '/api/v2/disbursements/wallet-balance', [
                    'accountNumber' => $walletAccount
                ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'availableBalance' => $response->json()['responseBody']['availableBalance'] ?? 0,
                    'ledgerBalance' => $response->json()['responseBody']['ledgerBalance'] ?? 0
                ];
            }

            return ['success' => false, 'message' => 'Failed to fetch Monnify balance'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Connection to Monnify failed: ' . $e->getMessage()];
        }
    }
}
