<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $provider;
    protected $apiKey;
    protected $senderId;
    protected $baseUrl;

    public function __construct()
    {
        $this->provider = Setting::where('key', 'whatsapp_provider')->value('value') ?? 'none';
        $this->apiKey = Setting::where('key', 'whatsapp_api_key')->value('value');
        $this->senderId = Setting::where('key', 'whatsapp_sender_id')->value('value');
        $this->baseUrl = Setting::where('key', 'whatsapp_base_url')->value('value');
    }

    public function sendMessage($to, $message)
    {
        if ($this->provider === 'none' || !$this->apiKey) {
            Log::info("WhatsApp Service: Message skipped (Provider disabled or API key missing)");
            return false;
        }

        // Clean phone number (ensure it has country code if needed, but for now assuming standard formats)
        $to = $this->formatPhoneNumber($to);

        if ($this->provider === 'termii') {
            return $this->sendViaTermii($to, $message);
        } elseif ($this->provider === 'sendchamp') {
            return $this->sendViaSendchamp($to, $message);
        }

        return false;
    }

    protected function formatPhoneNumber($phone)
    {
        // Simple Nigerian phone number formatter (ensure 234 prefix)
        if (str_starts_with($phone, '0')) {
            return '234' . substr($phone, 1);
        }
        if (!str_starts_with($phone, '234')) {
            return '234' . $phone;
        }
        return $phone;
    }

    protected function sendViaTermii($to, $message)
    {
        $url = $this->baseUrl ?: 'https://api.ng.termii.com/api/sms/send';
        
        $response = Http::post($url, [
            'api_key' => $this->apiKey,
            'to' => $to,
            'from' => $this->senderId,
            'sms' => $message,
            'type' => 'plain',
            'channel' => 'whatsapp', // Termii WhatsApp channel
        ]);

        if ($response->successful()) {
            return true;
        }

        Log::error("WhatsApp Service (Termii) Error: " . $response->body());
        return false;
    }

    protected function sendViaSendchamp($to, $message)
    {
        $url = $this->baseUrl ?: 'https://api.sendchamp.com/api/v1/whatsapp/message/send';
        
        $response = Http::withToken($this->apiKey)->post($url, [
            'recipient' => $to,
            'sender' => $this->senderId,
            'message' => $message,
            'type' => 'text',
        ]);

        if ($response->successful()) {
            return true;
        }

        Log::error("WhatsApp Service (Sendchamp) Error: " . $response->body());
        return false;
    }
}
