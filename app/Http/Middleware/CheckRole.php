<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class CheckRole
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
        if($request->user() === null){
            Session::flash('warning', 'Permisos insuficientes, debe iniciar sesion.');
            return redirect('/login');
        }
        $actions = $request->route()->getAction();
        $roles = isset($actions['roles']) ? $actions['roles'] : null;
        if ($request->user()->hasAnyRole($roles) || !$roles){
            return $next($request);
        }
        Session::flash('warning', 'Permisos insuficientes, debe iniciar sesion.');
        return redirect('/login');
    }
}
