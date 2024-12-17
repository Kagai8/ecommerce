<?php

namespace App;

use Illuminate\Support\Facades\Http;

class PaystackService
{
    public function initializePayment($email, $amount, $callbackUrl)
    {
        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))->post(env('PAYSTACK_BASE_URL') . '/transaction/initialize', [
            'email' => $email,
            'amount' => $amount * 100, // Convert to kobo
            'currency' => 'KES',
            'callback_url' => $callbackUrl,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Failed to initialize payment: ' . $response->body());
    }

    public function verifyPayment($reference)
    {
        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))->get(env('PAYSTACK_BASE_URL') . '/transaction/verify/' . $reference);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Failed to verify payment: ' . $response->body());
    }
}
