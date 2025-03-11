<?php

namespace App\Services;

use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\ApiKey;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PayPalService
{
    protected $provider;
    protected $apiKeyService;

    public function __construct(ApiKeyService $apiKeyService)
    {
        $this->apiKeyService = $apiKeyService;
        $this->provider = new PayPalClient;
        $this->provider->setApiCredentials(config('paypal'));
        $this->provider->getAccessToken();
    }

    public function createOrder($plan, $amount, $returnUrl, $cancelUrl)
    {
        try {
            $response = $this->provider->createOrder([
                'intent' => 'CAPTURE',
                'application_context' => [
                    'return_url' => $returnUrl,
                    'cancel_url' => $cancelUrl,
                ],
                'purchase_units' => [
                    [
                        'amount' => [
                            'currency_code' => 'USD',
                            'value' => $amount,
                        ],
                        'description' => 'API Key Purchase - ' . ucfirst($plan) . ' Plan',
                    ]
                ]
            ]);

            Log::info('PayPal Order Response: ' . json_encode($response));

            return $response;
        } catch (\Exception $e) {
            Log::error('PayPal process error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function capturePayment($orderId)
    {
        try {
            $response = $this->provider->capturePaymentOrder($orderId);
            Log::info('PayPal Capture Response: ' . json_encode($response));

            return $response;
        } catch (\Exception $e) {
            Log::error('PayPal capture error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function generateApiKey($plan, $paymentResponse, $amount, $email = null)
    {
        $apiKeyData = [
            'name' => 'PayPal Purchase - ' . ucfirst($plan) . ' Plan',
            'plan' => $plan,
            'email' => $email,
        ];

        $apiKey = $this->apiKeyService->createApiKeyNoUser($apiKeyData);

        $payerEmail = $email ?? $paymentResponse['payer']['email_address'] ?? null;

        Payment::create([
            'amount' => $amount,
            'paypal_order_id' => $paymentResponse['id'],
            'payer_email' => $payerEmail,
            'api_key_id' => $apiKey->id,
            'status' => 'completed',
        ]);

        return $apiKey;
    }
}