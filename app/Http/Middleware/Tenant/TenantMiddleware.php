<?php

namespace App\Http\Middleware\Tenant;

use Closure;
use Auth;
use App\Tenant\ManagerTenant;
use App\User;

class TenantMiddleware
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
        $chave = Auth::user();

        if($chave == 'restaurante') {
            return $next($request);
        } else {
            app(ManagerTenant::class)->setConnection($chave);
        }

        return $next($request);
    }
}
