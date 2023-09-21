<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->email_verified_at !== null) {
            return $next($request);
        }
        if (auth()->check() && auth()->user()->email_verified_at === null) {
            return redirect()
                ->route('user.information', [
                    'token' => auth()->user()->remember_token
                ]);
        }

        // save destination url, then after login, can redirect to destination url
        if (!session()->has('url.intended')) {
            session(['url.intended' => $request->url()]);
        }
        
        return redirect()->route('login.method');
    }
}
