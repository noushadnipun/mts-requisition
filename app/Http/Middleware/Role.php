<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();
        if ($user != null) {
            if ($user->isAdmin($request->user()->id))
                return $next($request);

            foreach ($roles as $role) {
                // Check if user has the role This check will depend on how your roles are set up
                if ($user->hasRole($request->user()->id, $role)) {
                    return $next($request);
                }
            }
            return redirect('oops');
        } else {
            return redirect(route('login'));
        }
    }
}
