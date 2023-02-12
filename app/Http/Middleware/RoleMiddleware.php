<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class RoleMiddleware {
    public function handle(Request $request, Closure $next, $rol) {

        // Si el usuario no está autenticado
        if (!Auth::check()) {
            return response()->json([
                'error' => 'No tiene permisos para realizar esta acción',
            ], 401);
        }

        $roles = array_slice(func_get_args(), 2);

        // Si el usuario no tiene el rol que se le pasa por parametro
        if (!in_array(Auth::user()->rol, $roles)) {
            return response()->json([
                'error' => 'No tiene permisos para realizar esta acción',
            ], 401);
        }


        return $next($request);
    }
}