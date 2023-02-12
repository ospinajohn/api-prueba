<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddDefaultHeaders {

    public function handle(Request $request, Closure $next) {
        // enviar cabeceras por defecto accept application/json
        $request->headers->set('Accept', 'application/json');
        $request->headers->set('Content-Type', 'application/json');

        return $next($request);
    }
}