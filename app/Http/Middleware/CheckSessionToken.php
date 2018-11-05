<?php

namespace App\Http\Middleware;

use Closure;

class CheckSessionToken {

    public function handle($request, Closure $next){
        if (!$request->session()->exists('token') || !$request->session()->get('token.access_token')) {
            // user value cannot be found in session
            return \App\App::redirectToLogin()->with(['error' => 'You must be authenticated to view this content']);
        }

        return $next($request);
    }

}
