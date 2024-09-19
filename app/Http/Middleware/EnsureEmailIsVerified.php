<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If user is authenticated but hasn't verified email, redirect to a warning page
        if (Auth::check() && is_null(Auth::user()->email_verified_at)) {
            return redirect()->route('account.verifyEmailWarning'); // Custom warning page
        }

        return $next($request);
    }
}
