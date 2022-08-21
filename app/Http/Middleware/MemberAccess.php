<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class MemberAccess
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
        $user = $request->user();
        if (!$user)
            return redirect()->route("auth.login");

        if (!$request->user()->email_verified_at)
            return redirect()->route("verification.notice");

        if (!in_array($user->level, [User::LEVEL_5, User::LEVEL_9])) {
            message()->default("Você não possui permissão para acessar esta área.")->flash();
            return redirect()->route("front.index");
        }

        return $next($request);
    }
}
