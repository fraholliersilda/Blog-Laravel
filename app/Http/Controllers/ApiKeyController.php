<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApiKeyRequest;
use App\Models\ApiKey;
use App\Services\ApiKeyService;
use Log;
use Request;

class ApiKeyController extends Controller
{

    protected $apiKeyService;

    public function __construct(ApiKeyService $apiKeyService)
    {
        $this->apiKeyService = $apiKeyService;
    }

    public function index()
    {
        try {
            $apiKeys = $this->apiKeyService->getUserApiKeys();
            return view('api-keys.index', compact('apiKeys'));
        } catch (\Exception $e) {
            Log::error('Error fetching API keys: ' . $e->getMessage());
            toastr()->error('Failed to load API keys');
            return redirect()->back();
        }
    }


    public function store(StoreApiKeyRequest $request)
    {
        try {
            $apiKey = $this->apiKeyService->createApiKey($request->validated());
            toastr()->success('API key creaed successfully');
            return redirect()->route('api-keys.index')
                ->with('generated_key', $apiKey->key);
        } catch (\Exception $e) {
            Log::error('Error creating API keys: ' . $e->getMessage());
            toastr()->error('Failed to create API keys');
            return redirect()->back();
        }

    }


    public function destroy(ApiKey $apiKey)
    {
        try {
            $this->apiKeyService->deleteApiKey($apiKey);
            toastr()->success('API key deleted successfully');
            return redirect()->route('api-keys.index');
        } catch (\Exception $e) {
            Log::error('Error deleting API keys: ' . $e->getMessage());
            toastr()->error('Failed to delte API key');
            return redirect()->back();
        }
    }

    public function showPurchasePage()
    {

        return view('api-keys.purchase');
    }


    public function showPurchaseSuccess(Request $request)
    {
        $apiKey = request()->query('key');

        if (!$apiKey) {
            return redirect()->route('api-keys.purchase');
        }

        return view('api-keys.success', compact('apiKey'));
    }

}
