<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PayPalPaymentRequest;
use App\Services\PayPalService;
use Illuminate\Support\Facades\Log;

class PayPalController extends Controller
{
    protected $paypalService;

    public function __construct(PayPalService $paypalService)
    {
        $this->paypalService = $paypalService;
    }

    public function processPayment(PayPalPaymentRequest $request)
    {
        $plan = $request->plan;
        $amount = $request->amount;
        $email = $request->email;
        $returnUrl = route('paypal.success');
        $cancelUrl = route('paypal.cancel');


        try {
            $response = $this->paypalService->createOrder($plan, $amount, $returnUrl, $cancelUrl);

            if (isset($response['id']) && $response['id'] != null) {
                session([
                    'paypal_order_id' => $response['id'],
                    'plan' => $plan,
                    'amount' => $amount,
                    'buyer_email' => $email,
                ]);

                foreach ($response['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        return redirect($link['href']);
                    }
                }

                toastr()->error('Something went wrong with PayPal. Please try again.');
                return redirect()->route('api-keys.purchase');
            } else {
                Log::error('PayPal API error: ' . json_encode($response));
                toastr()->error('PayPal API error. Please try again later.');
                return redirect()->route('api-keys.purchase');
            }
        } catch (\Exception $e) {
            toastr()->error('An error occurred processing your payment. Please try again later.');
            return redirect()->route('api-keys.purchase');
        }
    }

    public function paymentSuccess(Request $request)
    {
        $orderId = session('paypal_order_id');
        $plan = session('plan');
        $amount = session('amount');
        $email = session('buyer_email');

        if (!$orderId) {
            toastr()->error('Payment information not found.');
            return redirect()->route('api-keys.purchase');
        }

        try {
            $response = $this->paypalService->capturePayment($orderId);

            if (isset($response['status']) && $response['status'] == 'COMPLETED') {
                $apiKey = $this->paypalService->generateApiKey($plan, $response, $amount, $email);

                session()->forget(['paypal_order_id', 'plan', 'amount', 'email']);

                toastr()->success('Payment completed successfully! Your API key has been generated.');
                return redirect()->route('api-keys.purchase.success', ['key' => $apiKey->key]);
            } else {
                toastr()->error('Payment failed to complete. Please try again.');
                return redirect()->route('api-keys.purchase');
            }
        } catch (\Exception $e) {
            toastr()->error('An error occurred finalizing your payment. Please contact support.');
            return redirect()->route('api-keys.purchase');
        }
    }

    public function paymentCancel()
    {
        session()->forget(['paypal_order_id', 'plan', 'amount']);
        toastr()->error('Payment was cancelled.');
        return redirect()->route('api-keys.purchase');
    }
}