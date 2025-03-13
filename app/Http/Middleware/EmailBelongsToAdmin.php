<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class EmailBelongsToAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $email = $request->query('email');

        if (!$email) {
            return response()->json([
                'message' => 'Unauthorized. Email parameter is required.'
            ], Response::HTTP_FORBIDDEN);
        }

        $user = User::where('email', $email)->first();

        if (!$user || !$user->is_admin) {
            return response()->json([
                'message' => 'Unauthorized. Access restricted to admins only.'
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
