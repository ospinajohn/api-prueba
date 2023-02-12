<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware {
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request) { // este metodo es para redireccionar a la ruta de login
        if (!$request->expectsJson()) {
            return route('login');
        }
    }

    public function handle($request, Closure $next, ...$guards) {
        if ($token = $request->header('Authorization')) {
            $token = str_replace('Bearer ', '', $token);
            $request->headers->set('Authorization', 'Bearer ' . $token);
        }
        if ($token = $request->cookie('jwt')) {
            $request->headers->set('Authorization', 'Bearer ' . $token);
        }
        $this->authenticate($request, $guards);
        return $next($request);
    }

    
}