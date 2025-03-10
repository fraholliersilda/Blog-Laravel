<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApiKeyRequest;
use App\Models\ApiKey;
use App\Services\ApiKeyService;
use Auth;
use Illuminate\Http\Request;
use Log;

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


}
