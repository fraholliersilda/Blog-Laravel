<?php

namespace App\Services;

use App\Models\ApiKey;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class ApiKeyService{

    public function getUserApiKeys()
    {
        return ApiKey::all();
    }

    public function createApiKey(array $data)
    {
        return ApiKey::create([
            'name' => $data['name'],
            'key' => ApiKey::generateKey(),
            'user_id' => Auth::id(),
            'expires_at' => $data['expires_at'] ?? null,
            'email' => Auth::check() ? Auth::user()->email : $data['email'],
        ]);
    }

    public function deleteApiKey(ApiKey $apiKey)
    {
        return $apiKey->delete();
    }

    public function createApiKeyNoUser(array $data)
    {
        $key = Str::random(32);

        $apiKey = ApiKey::create([
            'key' => $key,
            'name' => $data['name'] ?? 'API Key',
            'user_id' => null,
            'email' => $data['email'] ?? null,
            'plan' => $data['plan'] ?? 'basic',
            'is_active' => true,
            'expires_at' => now()->addMonth(),
            'rate_limit' => $data['plan'] === 'premium' ? null : 1000,
        ]);

        return $apiKey;
    }

    public function findApiKeysByEmail($email)
    {
        return ApiKey::byEmail($email)->get();
    }
}
