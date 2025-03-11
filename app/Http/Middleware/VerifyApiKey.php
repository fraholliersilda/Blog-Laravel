<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Log;

class VerifyApiKey
{
    public function handle(Request $request, Closure $next): Response
    {
        $bearerToken = $request->bearerToken();

        if (!$bearerToken) {
            return response()->json([
                'message' => 'Unauthorized. API key is missing.'
            ], Response::HTTP_FORBIDDEN);
        }

        $apiKey = ApiKey::where('key', $bearerToken)->first();

        if (!$apiKey || !$apiKey->isValid()) {
            return response()->json([
                'message' => 'Unauthorized. Invalid API key.'
            ], Response::HTTP_FORBIDDEN);
        }

        $email = $request->query('email');
        if (!$email) {
            return response()->json([
                'message' => 'Unauthorized. Email parameter is required.'
            ], Response::HTTP_FORBIDDEN);
        }

        if ($apiKey->user_id) {
            $user = $apiKey->user;
            if (!$user || $user->email !== $email) {
                return response()->json([
                    'message' => 'Unauthorized. Email does not match the authenticated user.'
                ], Response::HTTP_FORBIDDEN);
            }
        }
        else {
            if ($apiKey->email !== $email) {
                return response()->json([
                    'message' => 'Unauthorized. Email does not match the registered API key.'
                ], Response::HTTP_FORBIDDEN);
            }
        }

        try {
            $apiKey->markAsUsed();
            Log::info('API key ' . $apiKey->id . ' marked as used at ' . now());
        } catch (\Exception $e) {
            Log::error('Failed to update API key last_used_at: ' . $e->getMessage());
        }

        if ($apiKey->user_id) {
            $request->setUserResolver(fn() => $apiKey->user);
        }

        return $next($request);
    }
}
