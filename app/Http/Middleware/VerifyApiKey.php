<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiKey
{
    public function handle(Request $request, Closure $next): Response
    {
        $bearerToken = $request->bearerToken();

        if (!$bearerToken) {
            return response()->json([
                'message' => 'Unauthorized. API key is missing.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $apiKey = ApiKey::where('key', $bearerToken)->first();

        if (!$apiKey || !$apiKey->isValid()) {
            return response()->json([
                'message' => 'Unauthorized. Invalid API key.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        try {
            $apiKey->last_used_at = now();
            $apiKey->save();

            \Illuminate\Support\Facades\Log::info('API key ' . $apiKey->id . ' marked as used at ' . now());
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to update API key last_used_at: ' . $e->getMessage());
        }

        $request->setUserResolver(function () use ($apiKey) {
            return $apiKey->user;
        });

        return $next($request);
    }
}
