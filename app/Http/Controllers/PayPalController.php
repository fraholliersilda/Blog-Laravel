<?php
// app/Http/Controllers/PayPalController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Str;
use App\Models\ApiKey;
use App\Models\Payment;
use App\Services\ApiKeyService;
use Log;

class PayPalController extends Controller
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

    public function processPayment(Request $request)
    {
        $request->validate([
            'plan' => 'required|in:basic,premium',
            'amount' => 'required|numeric',
        ]);

        $plan = $request->plan;
        $amount = $request->amount;

        $returnUrl = route('paypal.success');
        $cancelUrl = route('paypal.cancel');

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

            if (isset($response['id']) && $response['id'] != null) {
                session([
                    'paypal_order_id' => $response['id'],
                    'plan' => $plan,
                    'amount' => $amount,
                ]);

                foreach ($response['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        return redirect($link['href']);
                    }
                }

                return redirect()->route('api-keys.purchase')->with('error', 'Something went wrong with PayPal. Please try again.');
            } else {
                Log::error('PayPal API error: ' . json_encode($response));
                return redirect()->route('api-keys.purchase')->with('error', 'PayPal API error. Please try again later.');
            }
        } catch (\Exception $e) {
            Log::error('PayPal process error: ' . $e->getMessage());
            return redirect()->route('api-keys.purchase')->with('error', 'An error occurred processing your payment. Please try again later.');
        }
    }

    public function paymentSuccess(Request $request)
    {
        $orderId = session('paypal_order_id');
        $plan = session('plan');
        $amount = session('amount');

        if (!$orderId) {
            return redirect()->route('api-keys.purchase')->with('error', 'Payment information not found.');
        }

        try {
            $response = $this->provider->capturePaymentOrder($orderId);

            if (isset($response['status']) && $response['status'] == 'COMPLETED') {
                $apiKey = $this->generateApiKey($plan, $response);

                session()->forget(['paypal_order_id', 'plan', 'amount']);

                return redirect()->route('api-keys.purchase.success', ['key' => $apiKey->key]);
            } else {
                Log::error('PayPal capture error: ' . json_encode($response));
                return redirect()->route('api-keys.purchase')->with('error', 'Payment failed to complete. Please try again.');
            }
        } catch (\Exception $e) {
            Log::error('PayPal capture error: ' . $e->getMessage());
            return redirect()->route('api-keys.purchase')->with('error', 'An error occurred finalizing your payment. Please contact support.');
        }
    }

    public function paymentCancel()
    {
        session()->forget(['paypal_order_id', 'plan', 'amount']);
        return redirect()->route('api-keys.purchase')->with('error', 'Payment was cancelled.');
    }

    private function generateApiKey($plan, $paymentResponse)
    {
        $apiKeyData = [
            'name' => 'PayPal Purchase - ' . ucfirst($plan) . ' Plan',
            'plan' => $plan,
        ];

        $apiKey = $this->apiKeyService->createApiKeyNoUser($apiKeyData);

        $payerEmail = $paymentResponse['payer']['email_address'] ?? null;

        Payment::create([
            'amount' => session('amount'),
            'paypal_order_id' => $paymentResponse['id'],
            'payer_email' => $payerEmail,
            'api_key_id' => $apiKey->id,
            'status' => 'completed',
        ]);

        return $apiKey;
    }
}
