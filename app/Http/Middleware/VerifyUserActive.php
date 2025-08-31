<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyUserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        $user = $request->user()->user ?? $request->user();
        if($user && $user->motivo_inativo){
            if($request->expectsJson()){
                return response()->json([
                    'message' => __('Your account is not active!').' '.__('Reason').': '.__($user->motivo_inativo,locale:request()->getPreferredLanguage() ?? 'en_US'),
                ], 401); // 401 Unauthorized
            }else{
                $request->session()->flush();
                return redirect('/login')->dangerBanner(__('Your account is not active!').' '.__('Reason').': '.__($user->motivo_inativo,locale:request()->getPreferredLanguage() ?? 'en_US'));
            }
        }
        return $next($request);
    }
}
