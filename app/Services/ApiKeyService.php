<?php

namespace App\Services;

use App\Models\ApiKey;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;


class ApiKeyService{

    public function getUserApiKeys()
    {
        return ApiKey::where("user_id", Auth::user()->id)->get();
    }

    public function createApiKey(array $data)
    {
        return ApiKey::create([
            'name' => $data['name'],
            'key' => ApiKey::generateKey(),
            'user_id' => Auth::id(),
            'expires_at' => $data['expires_at'] ?? null,
        ]);
    }

    public function deleteApiKey(ApiKey $apiKey)
    {
        return $apiKey->delete();
    }
}
