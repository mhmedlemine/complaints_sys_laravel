<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        if (!$request->user() || !$request->user()->hasAnyRole($roles)) {
            abort(403, __('messages.Unauthorized action'));
        }
      
        return $next($request);
    }
}