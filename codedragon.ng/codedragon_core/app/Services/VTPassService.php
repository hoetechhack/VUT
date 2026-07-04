<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;

class VTPassService
{
    protected $apiKey;
    protected $publicKey;
    protected $secretKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = Setting::where('key', 'vtpass_api_key')->value('value') ?? '';
        $this->publicKey = Setting::where('key', 'vtpass_public_key')->value('value') ?? '';
        $this->secretKey = Setting::where('key', 'vtpass_secret_key')->value('value') ?? '';
        
        $env = Setting::where('key', 'platform_environment')->value('value') ?? 'sandbox';
        $this->baseUrl = ($env === 'live') ? 'https://vtpass.com/api' : 'https://sandbox.vtpass.com/api';
    }

    public function getVariationCodes($serviceID)
    {
        try {
            $response = Http::withHeaders([
                'api-key' => $this->apiKey,
                'public-key' => $this->publicKey,
                'secret-key' => $this->secretKey,
            ])->get($this->baseUrl . "/service-variations?serviceID=$serviceID");

            if ($response->successful()) {
                return $response->json()['content']['variations'];
            }
            return [];
        } catch (\Exception $e) {
            Log::error('VTPass Variation Error', ['error' => $e->getMessage()]);
            return [];
        }
    }

    public function purchase($serviceID, $variationCode, $amount, $phone, $requestId, $billersCode = null)
    {
        try {
            $payload = [
                'request_id' => $requestId,
                'serviceID' => $serviceID,
                'amount' => $amount,
                'phone' => $phone,
            ];

            // Only send variation_code if it's not airtime
            if ($variationCode && $variationCode !== 'airtime') {
                $payload['variation_code'] = $variationCode;
            }

            if ($billersCode) {
                $payload['billersCode'] = $billersCode;
            }

            Log::info("VTPass Purchase Request: ", $payload);

            $response = Http::withHeaders([
                'api-key' => $this->apiKey,
                'public-key' => $this->publicKey,
                'secret-key' => $this->secretKey,
            ])->post($this->baseUrl . '/pay', $payload);

            Log::info("VTPass Purchase Response: ", $response->json() ?? ['status' => $response->status()]);

            if ($response->successful() && isset($response->json()['code']) && $response->json()['code'] == '000') {
                return ['success' => true, 'data' => $response->json()];
            }

            return ['success' => false, 'message' => $response->json()['response_description'] ?? 'Purchase failed'];
        } catch (\Exception $e) {
            Log::error('VTPass Purchase Error', ['error' => $e->getMessage()]);
            return ['success' => false, 'message' => 'Connection to VTPass failed'];
        }
    }

    public function verifyAccount($serviceID, $billersCode, $type = null)
    {
        try {
            $payload = [
                'serviceID' => $serviceID,
                'billersCode' => $billersCode,
            ];
            if ($type) $payload['type'] = $type;

            Log::info("VTPass Verify Request: ", $payload);

            $response = Http::withHeaders([
                'api-key' => $this->apiKey,
                'public-key' => $this->publicKey,
                'secret-key' => $this->secretKey,
            ])->post($this->baseUrl . '/merchant-verify', $payload);

            Log::info("VTPass Verify Response: ", $response->json() ?? ['status' => $response->status()]);

            if ($response->successful() && isset($response->json()['content']['Customer_Name'])) {
                return ['success' => true, 'name' => $response->json()['content']['Customer_Name']];
            }
            return ['success' => false, 'message' => $response->json()['response_description'] ?? 'Verification failed'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Connection to VTPass failed'];
        }
    }

    public function getBalance()
    {
        try {
            $response = Http::withHeaders([
                'api-key' => $this->apiKey,
                'public-key' => $this->publicKey,
                'secret-key' => $this->secretKey,
            ])->get($this->baseUrl . '/balance');

            if ($response->successful() && isset($response->json()['contents']['balance'])) {
                return [
                    'success' => true,
                    'balance' => $response->json()['contents']['balance']
                ];
            }

            return ['success' => false, 'message' => 'Failed to fetch VTPass balance'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Connection to VTPass failed: ' . $e->getMessage()];
        }
    }
}
