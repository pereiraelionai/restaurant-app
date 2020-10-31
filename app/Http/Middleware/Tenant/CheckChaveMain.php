<?php

namespace App\Http\Middleware\Tenant;

use Closure;
use Auth;

class CheckChaveMain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        $chave = Auth::user()->db_chave;

        if($chave != config('tenant.chave_main')) {
            abort(401);
        }       

        return $next($request);
    }
}
